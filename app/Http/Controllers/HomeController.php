<?php

namespace App\Http\Controllers;

use App\BusinessLocation;

use App\Charts\CommonChart;
use App\Currency;
use App\Transaction;
use App\Utils\BusinessUtil;

use App\Utils\ModuleUtil;
use App\Utils\TransactionUtil;
use App\VariationLocationDetails;
use Datatables;
use DB;
use Illuminate\Http\Request;
use App\Utils\Util;

class HomeController extends Controller
{
    /**
     * All Utils instance.
     *
     */
    protected $businessUtil;
    protected $transactionUtil;
    protected $moduleUtil;
    protected $commonUtil;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        BusinessUtil $businessUtil,
        TransactionUtil $transactionUtil,
        ModuleUtil $moduleUtil,
        Util $commonUtil
    ) {
        $this->businessUtil = $businessUtil;
        $this->transactionUtil = $transactionUtil;
        $this->moduleUtil = $moduleUtil;
        $this->commonUtil = $commonUtil;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $business_id = request()->session()->get('user.business_id');

        if (!auth()->user()->can('dashboard.data')) {
            return view('home.index');
        }

        $fy = $this->businessUtil->getCurrentFinancialYear($business_id);
        $date_filters['this_fy'] = $fy;
        $date_filters['this_month']['start'] = date('Y-m-01');
        $date_filters['this_month']['end'] = date('Y-m-t');
        $date_filters['this_week']['start'] = date('Y-m-d', strtotime('monday this week'));
        $date_filters['this_week']['end'] = date('Y-m-d', strtotime('sunday this week'));

        $currency = Currency::where('id', request()->session()->get('business.currency_id'))->first();
        
        //Chart for sells last 30 days
        $sells_last_30_days = $this->transactionUtil->getSellsLast30Days($business_id);
        $labels = [];
        $all_sell_values = [];
        $dates = [];
        for ($i = 29; $i >= 0; $i--) {
            $date = \Carbon::now()->subDays($i)->format('Y-m-d');
            $dates[] = $date;

            $labels[] = date('j M Y', strtotime($date));

            if (!empty($sells_last_30_days[$date])) {
                $all_sell_values[] = (float) $sells_last_30_days[$date];
            } else {
                $all_sell_values[] = 0;
            }
        }

        //Get sell for indivisual locations
        $all_locations = BusinessLocation::forDropdown($business_id)->toArray();
        $location_sells = [];
        $sells_by_location = $this->transactionUtil->getSellsLast30Days($business_id, true);
        foreach ($all_locations as $loc_id => $loc_name) {
            $values = [];
            foreach ($dates as $date) {
                $sell = $sells_by_location->first(function ($item) use ($loc_id, $date) {
                    return $item->date == $date &&
                        $item->location_id == $loc_id;
                });
                
                if (!empty($sell)) {
                    $values[] = (float) $sell->total_sells;
                } else {
                    $values[] = 0;
                }
            }
            $location_sells[$loc_id]['loc_label'] = $loc_name;
            $location_sells[$loc_id]['values'] = $values;
        }

        $sells_chart_1 = new CommonChart;

        $sells_chart_1->labels($labels)
                        ->options($this->__chartOptions(__(
                            'home.total_sells',
                            ['currency' => $currency->code]
                            )));

        if (!empty($location_sells)) {
            foreach ($location_sells as $location_sell) {
                $sells_chart_1->dataset($location_sell['loc_label'], 'line', $location_sell['values']);
            }
        }

        if (count($all_locations) > 1) {
            $sells_chart_1->dataset(__('report.all_locations'), 'line', $all_sell_values);
        }

        //Chart for sells this financial year
        $sells_this_fy = $this->transactionUtil->getSellsCurrentFy($business_id, $fy['start'], $fy['end']);

        $labels = [];
        $values = [];

        $months = [];
        $date = strtotime($fy['start']);
        $last   = date('m-Y', strtotime($fy['end']));

        $fy_months = [];
        do {
            $month_year = date('m-Y', $date);
            $fy_months[] = $month_year;

            $month_number = date('m', $date);

            $labels[] = \Carbon::createFromFormat('m-Y', $month_year)
                            ->format('M-Y');
            $date = strtotime('+1 month', $date);

            if (!empty($sells_this_fy[$month_year])) {
                $values[] = (float) $sells_this_fy[$month_year];
            } else {
                $values[] = 0;
            }
        } while ($month_year != $last);

        $fy_sells_by_location = $this->transactionUtil->getSellsCurrentFy($business_id, $fy['start'], $fy['end'], true);
        $fy_sells_by_location_data = [];

        foreach ($all_locations as $loc_id => $loc_name) {
            $values_data = [];
            foreach ($fy_months as $month) {
                $sell = $fy_sells_by_location->first(function ($item) use ($loc_id, $month) {
                    return $item->yearmonth == $month &&
                        $item->location_id == $loc_id;
                });
                
                if (!empty($sell)) {
                    $values_data[] = (float) $sell->total_sells;
                } else {
                    $values_data[] = 0;
                }
            }
            $fy_sells_by_location_data[$loc_id]['loc_label'] = $loc_name;
            $fy_sells_by_location_data[$loc_id]['values'] = $values_data;
        }

        $sells_chart_2 = new CommonChart;
        $sells_chart_2->labels($labels)
                    ->options($this->__chartOptions(__(
                        'home.total_sells',
                        ['currency' => $currency->code]
                            )));
        if (!empty($fy_sells_by_location_data)) {
            foreach ($fy_sells_by_location_data as $location_sell) {
                $sells_chart_2->dataset($location_sell['loc_label'], 'line', $location_sell['values']);
            }
        }
        if (count($all_locations) > 1) {
            $sells_chart_2->dataset(__('report.all_locations'), 'line', $values);
        }

        //Get Dashboard widgets from module
        $module_widgets = $this->moduleUtil->getModuleData('dashboard_widget');

        $widgets = [];

        foreach ($module_widgets as $widget_array) {
            if (!empty($widget_array['position'])) {
                $widgets[$widget_array['position']][] = $widget_array['widget'];
            }
        }

        return view('home.index', compact('date_filters', 'sells_chart_1', 'sells_chart_2', 'widgets', 'all_locations'));
    }
    
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function screen(Request $request)
    {
            if(isset($_GET['q0'])){
                $line0 = $_GET['q0'];
                request()->session()->put(['line0' => $line0]);
            }
            if(isset($_GET['q1'])){
                $line1 = $_GET['q1'];
                request()->session()->put(['line1' => $line1]);
            }
            if(isset($_GET['q2'])){
                $line2 = $_GET['q2'];
                request()->session()->put(['line2' => $line2]);
            }
            if(isset($_GET['q3'])){
                $line3 = $_GET['q3'];
                request()->session()->put(['line3' => $line3]);
            }
            if(isset($_GET['q4'])){
                $line4 = $_GET['q4'];
                request()->session()->put(['line4' => $line4]);
            }
            if(isset($_GET['q5'])){
                $line5 = $_GET['q5'];
                request()->session()->put(['line5' => $line5]);
            }
            if(isset($_GET['q6'])){
                $line6 = $_GET['q6'];
                request()->session()->put(['line6' => $line6]);
            }
            if(isset($_GET['q7'])){
                $line7 = $_GET['q7'];
                request()->session()->put(['line7' => $line7]);
            }
            if(isset($_GET['q8'])){
                $line8 = $_GET['q8'];
                request()->session()->put(['line8' => $line8]);
            }
            if(isset($_GET['q9'])){
                $line9 = $_GET['q9'];
                request()->session()->put(['line9' => $line9]);
            }
            if(isset($_GET['q10'])){
                $line10 = $_GET['q10'];
                request()->session()->put(['line10' => $line10]);
            }
            if(isset($_GET['q11'])){
                $line11 = $_GET['q11'];
                request()->session()->put(['line11' => $line11]);
            }
            if(isset($_GET['12'])){
                $line12 = $_GET['12'];
                request()->session()->put(['line12' => $line12]);
            }
            if(isset($_GET['q13'])){
                $line13 = $_GET['q13'];
                request()->session()->put(['line13' => $line13]);
            }
            if(isset($_GET['q14'])){
                $line14 = $_GET['q14'];
                request()->session()->put(['line14' => $line14]);
            }
            if(isset($_GET['p1'])){
                $p1 = $_GET['p1'];
                request()->session()->put(['p1' => $p1]);
            }
            if(isset($_GET['p2'])){
                $p2 = $_GET['p2'];
                request()->session()->put(['p2' => $p2]);
            }
        
        return view('home.screen');
        
    }
    
    /**
     * For Customer: Customer Screen Products from POS Cart
     **/
    public function morcs(Request $request){
      
        echo "<tr>".request()->session()->get('line0')."</tr>";
        echo "<tr>".request()->session()->get('line1')."</tr>";
        echo "<tr>".request()->session()->get('line2')."</tr>";
        echo "<tr>".request()->session()->get('line3')."</tr>";
        echo "<tr>".request()->session()->get('line4')."</tr>";
        echo "<tr>".request()->session()->get('line5')."</tr>";
        echo "<tr>".request()->session()->get('line6')."</tr>";
        echo "<tr>".request()->session()->get('line7')."</tr>";
        echo "<tr>".request()->session()->get('line8')."</tr>";
        echo "<tr>".request()->session()->get('line9')."</tr>";
        echo "<tr>".request()->session()->get('line10')."</tr>";
        echo "<tr>".request()->session()->get('line11')."</tr>";
        echo "<tr>".request()->session()->get('line12')."</tr>";
        echo "<tr>".request()->session()->get('line13')."</tr>";
        echo "<tr>".request()->session()->get('line14')."</tr>";
    }
    
    /**
     * For Customer: Customer Screen Prices from POS Cart
     **/
    public function pcs(Request $request){

        echo "<b><span>Sipariş Toplamı => ".request()->session()->get('p1')."</span>";
        echo "<span style='float:right;color:darkgreen'>Toplam Ödenecek => ".request()->session()->get('p2')."</span></b>";

    }

    /**
     * Retrieves purchase and sell details for a given time period.
     *
     * @return \Illuminate\Http\Response
     */
    public function getTotals()
    {
        if (request()->ajax()) {
            $start = request()->start;
            $end = request()->end;
            $location_id = request()->location_id;
            $business_id = request()->session()->get('user.business_id');

            $purchase_details = $this->transactionUtil->getPurchaseTotals($business_id, $start, $end, $location_id);

            $sell_details = $this->transactionUtil->getSellTotals($business_id, $start, $end, $location_id);

            $transaction_types = [
                'purchase_return', 'sell_return', 'expense'
            ];

            $transaction_totals = $this->transactionUtil->getTransactionTotals(
                $business_id,
                $transaction_types,
                $start,
                $end
            );

            $total_purchase_inc_tax = !empty($purchase_details['total_purchase_inc_tax']) ? $purchase_details['total_purchase_inc_tax'] : 0;
            $total_purchase_return_inc_tax = $transaction_totals['total_purchase_return_inc_tax'];

            $total_purchase = $total_purchase_inc_tax - $total_purchase_return_inc_tax;
            $output = $purchase_details;
            $output['total_purchase'] = $total_purchase;

            $total_sell_inc_tax = !empty($sell_details['total_sell_inc_tax']) ? $sell_details['total_sell_inc_tax'] : 0;
            $total_sell_return_inc_tax = !empty($transaction_totals['total_sell_return_inc_tax']) ? $transaction_totals['total_sell_return_inc_tax'] : 0;

            $output['total_sell'] = $total_sell_inc_tax - $total_sell_return_inc_tax;

            $output['invoice_due'] = $sell_details['invoice_due'];
            $output['total_expense'] = $transaction_totals['total_expense'];
            
            return $output;
        }
    }

    /**
     * Retrieves sell products whose available quntity is less than alert quntity.
     *
     * @return \Illuminate\Http\Response
     */
    public function getProductStockAlert()
    {
        if (request()->ajax()) {
            $business_id = request()->session()->get('user.business_id');

            $query = VariationLocationDetails::join(
                'product_variations as pv',
                'variation_location_details.product_variation_id',
                '=',
                'pv.id'
            )
                    ->join(
                        'variations as v',
                        'variation_location_details.variation_id',
                        '=',
                        'v.id'
                    )
                    ->join(
                        'products as p',
                        'variation_location_details.product_id',
                        '=',
                        'p.id'
                    )
                    ->leftjoin(
                        'business_locations as l',
                        'variation_location_details.location_id',
                        '=',
                        'l.id'
                    )
                    ->leftjoin('units as u', 'p.unit_id', '=', 'u.id')
                    ->where('p.business_id', $business_id)
                    ->where('p.enable_stock', 1)
                    ->where('p.is_inactive', 0)
                    ->whereRaw('variation_location_details.qty_available <= p.alert_quantity');

            //Check for permitted locations of a user
            $permitted_locations = auth()->user()->permitted_locations();
            if ($permitted_locations != 'all') {
                $query->whereIn('variation_location_details.location_id', $permitted_locations);
            }

            $products = $query->select(
                'p.name as product',
                'p.type',
                'pv.name as product_variation',
                'v.name as variation',
                'l.name as location',
                'variation_location_details.qty_available as stock',
                'u.short_name as unit'
            )
                    ->groupBy('variation_location_details.id')
                    ->orderBy('stock', 'asc');

            return Datatables::of($products)
                ->editColumn('product', function ($row) {
                    if ($row->type == 'single') {
                        return $row->product;
                    } else {
                        return $row->product . ' - ' . $row->product_variation . ' - ' . $row->variation;
                    }
                })
                ->editColumn('stock', function ($row) {
                    $stock = $row->stock ? $row->stock : 0 ;
                    return '<span data-is_quantity="true" class="display_currency" data-currency_symbol=false>'. (float)$stock . '</span> ' . $row->unit;
                })
                ->removeColumn('unit')
                ->removeColumn('type')
                ->removeColumn('product_variation')
                ->removeColumn('variation')
                ->rawColumns([2])
                ->make(false);
        }
    }

    /**
     * Retrieves payment dues for the purchases.
     *
     * @return \Illuminate\Http\Response
     */
    public function getPurchasePaymentDues()
    {
        if (request()->ajax()) {
            $business_id = request()->session()->get('user.business_id');
            $today = \Carbon::now()->format("Y-m-d H:i:s");

            $query = Transaction::join(
                'contacts as c',
                'transactions.contact_id',
                '=',
                'c.id'
            )
                    ->leftJoin(
                        'transaction_payments as tp',
                        'transactions.id',
                        '=',
                        'tp.transaction_id'
                    )
                    ->where('transactions.business_id', $business_id)
                    ->where('transactions.type', 'purchase')
                    ->where('transactions.payment_status', '!=', 'paid')
                    ->whereRaw("DATEDIFF( DATE_ADD( transaction_date, INTERVAL IF(c.pay_term_type = 'days', c.pay_term_number, 30 * c.pay_term_number) DAY), '$today') <= 7");

            //Check for permitted locations of a user
            $permitted_locations = auth()->user()->permitted_locations();
            if ($permitted_locations != 'all') {
                $query->whereIn('transactions.location_id', $permitted_locations);
            }

            $dues =  $query->select(
                'transactions.id as id',
                'c.name as supplier',
                'ref_no',
                'final_total',
                DB::raw('SUM(tp.amount) as total_paid')
            )
                        ->groupBy('transactions.id');

            return Datatables::of($dues)
                ->addColumn('due', function ($row) {
                    $total_paid = !empty($row->total_paid) ? $row->total_paid : 0;
                    $due = $row->final_total - $total_paid;
                    return '<span class="display_currency" data-currency_symbol="true">' .
                    $due . '</span>';
                })
                ->editColumn('ref_no', function ($row) {
                    if (auth()->user()->can('purchase.view')) {
                        return  '<a href="#" data-href="' . action('PurchaseController@show', [$row->id]) . '"
                                    class="btn-modal" data-container=".view_modal">' . $row->ref_no . '</a>';
                    }
                    return $row->ref_no;
                })
                ->removeColumn('id')
                ->removeColumn('final_total')
                ->removeColumn('total_paid')
                ->rawColumns([1, 2])
                ->make(false);
        }
    }

    /**
     * Retrieves payment dues for the purchases.
     *
     * @return \Illuminate\Http\Response
     */
    public function getSalesPaymentDues()
    {
        if (request()->ajax()) {
            $business_id = request()->session()->get('user.business_id');
            $today = \Carbon::now()->format("Y-m-d H:i:s");

            $query = Transaction::join(
                'contacts as c',
                'transactions.contact_id',
                '=',
                'c.id'
            )
                    ->leftJoin(
                        'transaction_payments as tp',
                        'transactions.id',
                        '=',
                        'tp.transaction_id'
                    )
                    ->where('transactions.business_id', $business_id)
                    ->where('transactions.type', 'sell')
                    ->where('transactions.payment_status', '!=', 'paid')
                    ->whereNotNull('transactions.pay_term_number')
                    ->whereNotNull('transactions.pay_term_type')
                    ->whereRaw("DATEDIFF( DATE_ADD( transaction_date, INTERVAL IF(transactions.pay_term_type = 'days', transactions.pay_term_number, 30 * transactions.pay_term_number) DAY), '$today') <= 7");

            //Check for permitted locations of a user
            $permitted_locations = auth()->user()->permitted_locations();
            if ($permitted_locations != 'all') {
                $query->whereIn('transactions.location_id', $permitted_locations);
            }

            $dues =  $query->select(
                'transactions.id as id',
                'c.name as customer',
                'transactions.invoice_no',
                'final_total',
                DB::raw('SUM(tp.amount) as total_paid')
            )
                        ->groupBy('transactions.id');

            return Datatables::of($dues)
                ->addColumn('due', function ($row) {
                    $total_paid = !empty($row->total_paid) ? $row->total_paid : 0;
                    $due = $row->final_total - $total_paid;
                    return '<span class="display_currency" data-currency_symbol="true">' .
                    $due . '</span>';
                })
                ->editColumn('invoice_no', function ($row) {
                    if (auth()->user()->can('sell.view')) {
                        return  '<a href="#" data-href="' . action('SellController@show', [$row->id]) . '"
                                    class="btn-modal" data-container=".view_modal">' . $row->invoice_no . '</a>';
                    }
                    return $row->invoice_no;
                })
                ->removeColumn('id')
                ->removeColumn('final_total')
                ->removeColumn('total_paid')
                ->rawColumns([1, 2])
                ->make(false);
        }
    }

    public function loadMoreNotifications()
    {
        $notifications = auth()->user()->notifications()->orderBy('created_at', 'DESC')->paginate(10);

        if (request()->input('page') == 1) {
            auth()->user()->unreadNotifications->markAsRead();
        }
        $notifications_data = $this->commonUtil->parseNotifications($notifications);

        return view('layouts.partials.notification_list', compact('notifications_data'));
    }

    /**
     * Function to count total number of unread notifications
     *
     * @return json
     */
    public function getTotalUnreadNotifications()
    {
        $total_unread = auth()->user()->unreadNotifications->count();

        return [
            'total_unread' => $total_unread
        ];
    }

    private function __chartOptions($title)
    {
        return [
            'yAxis' => [
                    'title' => [
                        'text' => $title
                    ]
                ],
            'legend' => [
                'align' => 'right',
                'verticalAlign' => 'top',
                'floating' => true,
                'layout' => 'vertical'
            ],
        ];
    }
}
