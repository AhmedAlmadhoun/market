
<head>

    <style type="text/css">
     .goster{
     display:none;   
    }
    .kapat{
        display:none !important;
    }
    @media print {
            .pos_product_div{
                max-height:unset !important;
                overflow:unset !important;
            }
           
            .goster{
                        display:table-cell !important;
            }
    }
</style>
<script>
    let ajax_url = 0;
</script>
</head>
@extends('layouts.app')

@section('title', 'POS')

@section('content')
<section class="content">
	<input type="hidden" id="amount_rounding_method" value="{{$pos_settings['amount_rounding_method'] ?? ''}}">
	@if(!empty($pos_settings['allow_overselling']))
		<input type="hidden" id="is_overselling_allowed">
	@endif
	@if(session('business.enable_rp') == 1)
        <input type="hidden" id="reward_point_enabled">
    @endif
    @php
		$is_discount_enabled = $pos_settings['disable_discount'] != 1 ? true : false;
		$is_rp_enabled = session('business.enable_rp') == 1 ? true : false;
	@endphp
	{!! Form::open(['url' => action('SellPosController@store'), 'method' => 'post', 'id' => 'add_pos_sell_form' ]) !!}
	<div class="row mb-12">
		<div class="col-md-12">
			<div class="row">
				<div class="@if(empty($pos_settings['hide_product_suggestion'])) col-md-7 @else col-md-10 col-md-offset-1 @endif no-padding pr-12 fis-alani">
					<div class="box box-solid mb-12">
						<div class="box-body pb-0">
							{!! Form::hidden('location_id', $default_location->id, ['id' => 'location_id', 'data-receipt_printer_type' => !empty($default_location->receipt_printer_type) ? $default_location->receipt_printer_type : 'browser', 'data-default_accounts' => $default_location->default_payment_accounts]); !!}
							<!-- sub_type -->
							{!! Form::hidden('sub_type', isset($sub_type) ? $sub_type : null) !!}
							<input type="hidden" id="item_addition_method" value="{{$business_details->item_addition_method}}">
								@include('sale_pos.partials.pos_form')

								@include('sale_pos.partials.pos_form_totals')

								@include('sale_pos.partials.payment_modal')

								@if(empty($pos_settings['disable_suspend']))
									@include('sale_pos.partials.suspend_note_modal')
								@endif

								@if(empty($pos_settings['disable_recurring_invoice']))
									@include('sale_pos.partials.recurring_invoice_modal')
								@endif
							</div>
						</div>
					</div>
				@if(empty($pos_settings['hide_product_suggestion']) && !isMobile())
				<div class="col-md-5 no-padding no-print">
					@include('sale_pos.partials.pos_sidebar')
				</div>
				@endif
			</div>
		</div>
	</div>
	@include('sale_pos.partials.pos_form_actions')
	{!! Form::close() !!}
</section>

<section class="invoice print_section no-print" id="receipt_section">
</section>
<div class="modal fade contact_modal no-print" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
	@include('contact.create', ['quick_add' => true])
</div>
@if(empty($pos_settings['hide_product_suggestion']) && isMobile())
	@include('sale_pos.partials.mobile_product_suggestions')
@endif
<!-- /.content -->
<div class="modal fade register_details_modal" tabindex="-1" role="dialog" 
	aria-labelledby="gridSystemModalLabel">
</div>
<div class="modal fade close_register_modal" tabindex="-1" role="dialog" 
	aria-labelledby="gridSystemModalLabel">
</div>
<!-- quick product modal -->
<div class="modal fade quick_add_product_modal" tabindex="-1" role="dialog" aria-labelledby="modalTitle"></div>

@include('sale_pos.partials.configure_search_modal')

@include('sale_pos.partials.recent_transactions_modal')

@include('sale_pos.partials.weighing_scale_modal')

@stop
@section('css')
	<!-- include module css -->
    @if(!empty($pos_module_data))
        @foreach($pos_module_data as $key => $value)
            @if(!empty($value['module_css_path']))
                @includeIf($value['module_css_path'])
            @endif
        @endforeach
    @endif
@stop
@section('javascript')
    <script>
        $( document ).on( 'keypress', '.pos_quantity', function( e )
                {
                    if( e.keyCode == 46 && $( this ).val().indexOf( '.' ) != -1 )
                        e.preventDefault();
                 
                    var tmp = $( this ).val();
                    if( e.keyCode == 44 )
                    {
                        setTimeout(function()
                        {
                            if( tmp.indexOf( '.' ) == -1 )
                                e.target.value += '.';
                        }, 4 );
                        e.preventDefault();
                    }
            });
    </script>
	<script src="{{ asset('js/pos.js?v=' . $asset_v) }}"></script>
	<script src="{{ asset('js/printer.js?v=' . $asset_v) }}"></script>
	<script src="{{ asset('js/product.js?v=' . $asset_v) }}"></script>
	<script src="{{ asset('js/opening_stock.js?v=' . $asset_v) }}"></script>
	<script>
	    var sell_cash = $('.pos-express-finalize');
	    var print_button = $('#count_printer');
	    
	    sell_cash.on('click', function(e){
                $('.content').addClass('no-print');
                $('#count_printer').addClass('kapat');
            });
            
        print_button.on('click', function(e){
                $('.pos-express-finalize').addClass('kapat');
                $('#pos-draft').addClass('kapat');
                $('#pos-quotation').addClass('kapat');
                $('#pos-finalize').addClass('kapat');
            });
	</script>
	    <script>
	    var time = 2000;
	    
    /*setInterval(function(){
        if(jQuery('#urun_icleri').text().length > 0){
                
                var product0 = $(document.getElementsByClassName('cs_product_row')[0]);
                var query0 = product0;
                
                var product1 = $(document.getElementsByClassName('cs_product_row')[1]);
                var query1 = product1;
                
                var product2 = $(document.getElementsByClassName('cs_product_row')[2]);
                var query2 = product2;
                
                var product3 = $(document.getElementsByClassName('cs_product_row')[3]);
                var query3 = product3;
                
                var product4 = $(document.getElementsByClassName('cs_product_row')[4]);
                var query4 = product4;
                
                var product5 = $(document.getElementsByClassName('cs_product_row')[5]);
                var query5 = product5;
                
                var product6 = $(document.getElementsByClassName('cs_product_row')[6]);
                var query6 = product6;
                
                var product7 = $(document.getElementsByClassName('cs_product_row')[7]);
                var query7 = product7;
                
                var product8 = $(document.getElementsByClassName('cs_product_row')[8]);
                var query8 = product8;
                
                var product9 = $(document.getElementsByClassName('cs_product_row')[9]);
                var query9 = product9;
                
                var product10 = $(document.getElementsByClassName('cs_product_row')[10]);
                var query10 = product10;
                
                var product11 = $(document.getElementsByClassName('cs_product_row')[11]);
                var query11 = product11;
                
                var product12 = $(document.getElementsByClassName('cs_product_row')[12]);
                var query12 = product12;
                
                var product13 = $(document.getElementsByClassName('cs_product_row')[13]);
                var query13 = product13;
                
                var product14 = $(document.getElementsByClassName('cs_product_row')[14]);
                var query14 = product14;

                if (typeof (document.getElementsByClassName('cs_product_row')[0]) != undefined && typeof (document.getElementsByClassName('cs_product_row')[0]) != null && typeof (document.getElementsByClassName('cs_product_row')[0]) != 'undefined'){
                    var q0 = query0['0']['innerHTML'];
                    var p_total = $(document.getElementsByClassName('price_total')).text();
                    var p_t = p_total.replace('.', ',');
                    var p_payable =  $(document.getElementsByClassName('total_payable_span')).text();
                    var p_p = p_payable.replace('.', ',');
                }
                else{
                    var q0 = null;
                    var p_t = null;
                    var p_p = null;
                }
                if (typeof (document.getElementsByClassName('cs_product_row')[1]) != undefined && typeof (document.getElementsByClassName('cs_product_row')[1]) != null && typeof (document.getElementsByClassName('cs_product_row')[1]) != 'undefined'){
                    var q1 = query1['0']['innerHTML'];
                }
                else{
                    var q1 = null;
                }
                if (typeof (document.getElementsByClassName('cs_product_row')[2]) != undefined && typeof (document.getElementsByClassName('cs_product_row')[2]) != null && typeof (document.getElementsByClassName('cs_product_row')[2]) != 'undefined'){
                    var q2 = query2['0']['innerHTML'];
                }
                else{
                    var q2 = null;
                }
                if (typeof (document.getElementsByClassName('cs_product_row')[3]) != undefined && typeof (document.getElementsByClassName('cs_product_row')[3]) != null && typeof (document.getElementsByClassName('cs_product_row')[3]) != 'undefined'){
                    var q3 = query3['0']['innerHTML'];
                }
                else{
                    var q3 = null;
                }
                if (typeof (document.getElementsByClassName('cs_product_row')[4]) != undefined && typeof (document.getElementsByClassName('cs_product_row')[4]) != null && typeof (document.getElementsByClassName('cs_product_row')[4]) != 'undefined'){
                    var q4 = query4['0']['innerHTML'];
                }
                else{
                    var q4 = null;
                }
                if (typeof (document.getElementsByClassName('cs_product_row')[5]) != undefined && typeof (document.getElementsByClassName('cs_product_row')[5]) != null && typeof (document.getElementsByClassName('cs_product_row')[5]) != 'undefined'){
                    var q5 = query5['0']['innerHTML'];
                }
                else{
                    var q5 = null;
                }
                if (typeof (document.getElementsByClassName('cs_product_row')[6]) != undefined && typeof (document.getElementsByClassName('cs_product_row')[6]) != null && typeof (document.getElementsByClassName('cs_product_row')[6]) != 'undefined'){
                    var q6 = query6['0']['innerHTML'];
                }
                else{
                    var q6 = null;
                }
                if (typeof (document.getElementsByClassName('cs_product_row')[7]) != undefined && typeof (document.getElementsByClassName('cs_product_row')[7]) != null && typeof (document.getElementsByClassName('cs_product_row')[7]) != 'undefined'){
                    var q7 = query7['0']['innerHTML'];
                }
                else{
                    var q7 = null;
                }
                if (typeof (document.getElementsByClassName('cs_product_row')[8]) != undefined && typeof (document.getElementsByClassName('cs_product_row')[8]) != null && typeof (document.getElementsByClassName('cs_product_row')[8]) != 'undefined'){
                    var q8 = query8['0']['innerHTML'];
                }
                else{
                    var q8 = null;
                }
                if (typeof (document.getElementsByClassName('cs_product_row')[9]) != undefined && typeof (document.getElementsByClassName('cs_product_row')[9]) != null && typeof (document.getElementsByClassName('cs_product_row')[9]) != 'undefined'){
                    var q9 = query9['0']['innerHTML'];
                }
                else{
                    var q9 = null;
                }
                if (typeof (document.getElementsByClassName('cs_product_row')[10]) != undefined && typeof (document.getElementsByClassName('cs_product_row')[10]) != null && typeof (document.getElementsByClassName('cs_product_row')[10]) != 'undefined'){
                    var q10 = query10['0']['innerHTML'];
                }
                else{
                    var q10 = null;
                }
                if (typeof (document.getElementsByClassName('cs_product_row')[11]) != undefined && typeof (document.getElementsByClassName('cs_product_row')[11]) != null && typeof (document.getElementsByClassName('cs_product_row')[11]) != 'undefined'){
                    var q11 = query11['0']['innerHTML'];
                }
                else{
                    var q11 = null;
                }
                if (typeof (document.getElementsByClassName('cs_product_row')[12]) != undefined && typeof (document.getElementsByClassName('cs_product_row')[12]) != null && typeof (document.getElementsByClassName('cs_product_row')[12]) != 'undefined'){
                    var q12 = query12['0']['innerHTML'];
                }
                else{
                    var q12 = null;
                }
                if (typeof (document.getElementsByClassName('cs_product_row')[13]) != undefined && typeof (document.getElementsByClassName('cs_product_row')[13]) != null && typeof (document.getElementsByClassName('cs_product_row')[13]) != 'undefined'){
                    var q13 = query13['0']['innerHTML'];
                }
                else{
                    var q13 = null;
                }
                if (typeof (document.getElementsByClassName('cs_product_row')[14]) != undefined && typeof (document.getElementsByClassName('cs_product_row')[14]) != null && typeof (document.getElementsByClassName('cs_product_row')[14]) != 'undefined'){
                    var q14 = query14['0']['innerHTML'];
                }
                else{
                    var q14 = null;
                }
                if(q0 != null){
                    $.ajax({
                        url: '/screen',
                        type: 'GET',
                        data: {q0:q0,q1:q1,q2:q2,q3:q3,q4:q4,q5:q5,q6:q6,q7:q7,q8:q8,q9:q9,q10:q10,q11:q11,q12:q12,q13:q13,q14:q14,p1:p_t,p2:p_p},
                        dataType: 'html',
                    })
                }
                else{
                    var clean_cart = $.ajax({
                        url: '/screen',
                        type: 'GET',
                        data: {q0:q0,q1:q1,q2:q2,q3:q3,q4:q4,q5:q5,q6:q6,q7:q7,q8:q8,q9:q9,q10:q10,q11:q11,q12:q12,q13:q13,q14:q14,p1:null,p2:null},
                        dataType: 'html',
                    })
                    clean_cart.abort();
                }
        }
        
    }, time);*/
   
    
    
    </script>
	@include('sale_pos.partials.keyboard_shortcuts')

	<!-- Call restaurant module if defined -->
    @if(in_array('tables' ,$enabled_modules) || in_array('modifiers' ,$enabled_modules) || in_array('service_staff' ,$enabled_modules))
    	<script src="{{ asset('js/restaurant.js?v=' . $asset_v) }}"></script>
    @endif
    <!-- include module js -->
    @if(!empty($pos_module_data))
	    @foreach($pos_module_data as $key => $value)
            @if(!empty($value['module_js_path']))
                @includeIf($value['module_js_path'], ['view_data' => $value['view_data']])
            @endif
	    @endforeach
	@endif
@endsection