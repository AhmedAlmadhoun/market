
<?php
    $prod_id = $product->product_id."_".$row_count;
?>

	

<tr class="product_row" data-row_index="{{$row_count}}">
	<td>
		@php
			$product_name = $product->product_name;
		@endphp

		@if($edit_price || $edit_discount )
		<div title="@lang('lang_v1.pos_edit_product_price_help')">
		<span class="text-link text-info cursor-pointer urun_ad" data-toggle="modal" data-target="#row_edit_product_price_modal_{{$row_count}}">
			{!! $product_name !!}
			
		</span>
		</div>
		@else
			{!! $product_name !!}
		@endif
		<input type="hidden" class="enable_sr_no" value="{{$product->enable_sr_no}}">
		<input type="hidden" 
			class="product_type" 
			name="products[{{$row_count}}][product_type]" 
			value="{{$product->product_type}}">

		@php
			$hide_tax = 'hide';
	        if(session()->get('business.enable_inline_tax') == 1){
	            $hide_tax = '';
	        }
	        
			$tax_id = $product->tax_id;
			$item_tax = !empty($product->item_tax) ? $product->item_tax : 0;
			$unit_price_inc_tax = $product->sell_price_inc_tax;
			if($hide_tax == 'hide'){
				$tax_id = null;
				$unit_price_inc_tax = $product->default_sell_price;
			}
		@endphp

		<div class="modal fade row_edit_product_price_model" id="row_edit_product_price_modal_{{$row_count}}" tabindex="-1" role="dialog">
			@include('sale_pos.partials.row_edit_product_price_modal')
		</div>

		@if(in_array('modifiers' , $enabled_modules))
			<div class="modifiers_html">
				@if(!empty($product->product_ms))
					@include('restaurant.product_modifier_set.modifier_for_product', array('edit_modifiers' => true, 'row_count' => $loop->index, 'product_ms' => $product->product_ms ) )
				@endif
			</div>
		@endif

		@php
			$max_qty_rule = $product->qty_available;
			$max_qty_msg = __('validation.custom-messages.quantity_not_available', ['qty'=> $product->formatted_qty_available, 'unit' => $product->unit  ]);
		@endphp

		@if( session()->get('business.enable_lot_number') == 1 || session()->get('business.enable_product_expiry') == 1)
		@php
			$lot_enabled = session()->get('business.enable_lot_number');
			$exp_enabled = session()->get('business.enable_product_expiry');
			$lot_no_line_id = '';
			if(!empty($product->lot_no_line_id)){
				$lot_no_line_id = $product->lot_no_line_id;
			}
		@endphp
		@if(!empty($product->lot_numbers))
			<select class="form-control lot_number input-sm" name="products[{{$row_count}}][lot_no_line_id]" @if(!empty($product->transaction_sell_lines_id)) disabled @endif>
				<option value="">@lang('lang_v1.lot_n_expiry')</option>
				@foreach($product->lot_numbers as $lot_number)
					@php
						$selected = "";
						if($lot_number->purchase_line_id == $lot_no_line_id){
							$selected = "selected";

							$max_qty_rule = $lot_number->qty_available;
							$max_qty_msg = __('lang_v1.quantity_error_msg_in_lot', ['qty'=> $lot_number->qty_formated, 'unit' => $product->unit  ]);
						}

						$expiry_text = '';
						if($exp_enabled == 1 && !empty($lot_number->exp_date)){
							if( \Carbon::now()->gt(\Carbon::createFromFormat('Y-m-d', $lot_number->exp_date)) ){
								$expiry_text = '(' . __('report.expired') . ')';
							}
						}

						//preselected lot number if product searched by lot number
						if(!empty($purchase_line_id) && $purchase_line_id == $lot_number->purchase_line_id) {
							$selected = "selected";

							$max_qty_rule = $lot_number->qty_available;
							$max_qty_msg = __('lang_v1.quantity_error_msg_in_lot', ['qty'=> $lot_number->qty_formated, 'unit' => $product->unit  ]);
						}
					@endphp
					<option value="{{$lot_number->purchase_line_id}}" data-qty_available="{{$lot_number->qty_available}}" data-msg-max="@lang('lang_v1.quantity_error_msg_in_lot', ['qty'=> $lot_number->qty_formated, 'unit' => $product->unit  ])" {{$selected}}>@if(!empty($lot_number->lot_number) && $lot_enabled == 1){{$lot_number->lot_number}} @endif @if($lot_enabled == 1 && $exp_enabled == 1) - @endif @if($exp_enabled == 1 && !empty($lot_number->exp_date)) @lang('product.exp_date'): {{@format_date($lot_number->exp_date)}} @endif {{$expiry_text}}</option>
				@endforeach
			</select>
		@endif
	@endif

	</td>

	<td>
		{{-- If edit then transaction sell lines will be present --}}
		@if(!empty($product->transaction_sell_lines_id))
			<input type="hidden" name="products[{{$row_count}}][transaction_sell_lines_id]" class="form-control" value="{{$product->transaction_sell_lines_id}}">
		@endif

		<input type="hidden" name="products[{{$row_count}}][product_id]" class="form-control product_id fetch_cs__{{$prod_id}}" value="{{$product->product_id}}">

		<input type="hidden" value="{{$product->variation_id}}" 
			name="products[{{$row_count}}][variation_id]" class="row_variation_id">
		<input type="hidden" value="{{$product->enable_stock}}" 
			name="products[{{$row_count}}][enable_stock]">
		
		@if(empty($product->quantity_ordered))
			@php
				$product->quantity_ordered = 1;
			@endphp
		@endif

		@php
			$multiplier = 1;
			$allow_decimal = true;
			if($product->unit_allow_decimal != 1) {
				$allow_decimal = false;
			}
		@endphp
		@foreach($sub_units as $key => $value)
        	@if(!empty($product->sub_unit_id) && $product->sub_unit_id == $key)
        		@php
        			$multiplier = $value['multiplier'];
        			$max_qty_rule = $max_qty_rule / $multiplier;
        			$unit_name = $value['name'];
        			$max_qty_msg = __('validation.custom-messages.quantity_not_available', ['qty'=> $max_qty_rule, 'unit' => $unit_name  ]);

        			if(!empty($product->lot_no_line_id)){
        				$max_qty_msg = __('lang_v1.quantity_error_msg_in_lot', ['qty'=> $max_qty_rule, 'unit' => $unit_name  ]);
        			}

        			if($value['allow_decimal']) {
        				$allow_decimal = true;
        			}
        		@endphp
        	@endif
        @endforeach
		<div class="input-group input-number">
			<span class="input-group-btn no-print"><button type="button" class="btn btn-default btn-flat quantity-down"><i class="fa fa-minus text-danger"></i></button></span>
		<input type="text" data-min="1"  style="width: auto"
			class="form-control pos_quantity input_number mousetrap input_quantity prod_{{$prod_id}}" 
			value="{{@format_quantity($product->quantity_ordered)}}" name="products[{{$row_count}}][quantity]" data-allow-overselling="@if(empty($pos_settings['allow_overselling'])){{'true'}}@else{{'true'}}@endif" 
			@if($allow_decimal) 
				data-decimal=1 
			@else 
				data-decimal=0 
				data-rule-abs_digit="true" 
				data-msg-abs_digit="@lang('lang_v1.decimal_value_not_allowed')" 
			@endif
			data-rule-required="true" 
			data-msg-required="@lang('validation.custom-messages.this_field_is_required')" 
			@if($product->enable_stock && empty($pos_settings['allow_overselling']) )
				data-rule-max-value="{{$max_qty_rule}}" data-qty_available="{{$product->qty_available}}" data-msg-max-value="{{$max_qty_msg}}" 
				data-msg_max_default="@lang('validation.custom-messages.quantity_not_available', ['qty'=> $product->formatted_qty_available, 'unit' => $product->unit  ])" 
			@endif 
		>
		<span class="input-group-btn no-print"><button type="button" class="btn btn-default btn-flat quantity-up"><i class="fa fa-plus text-success"></i></button></span>
		
		<input type="hidden" name="products[{{$row_count}}][product_unit_id]" value="{{$product->unit_id}}">
		@if(count($sub_units) > 0)
			<select style="min-width:115px" name="products[{{$row_count}}][sub_unit_id]" class="form-control input-sm sub_unit no-print">
                @foreach($sub_units as $key => $value)
                    <option value="{{$key}}" data-multiplier="{{$value['multiplier']}}" data-unit_name="{{$value['name']}}" data-allow_decimal="{{$value['allow_decimal']}}" @if(!empty($product->sub_unit_id) && $product->sub_unit_id == $key) selected @endif>
                        {{$value['name']}}
                    </option>
                @endforeach
           </select>
		@else
			{{$product->unit}}
		@endif
        <span class="goster" style="display:none">{{$product->unit}}</span>
		<!--Kombu ürünler ve varsayılan satış fiyatı için bu alana aynı klasordeki txt dosyasının icindekiler yazılacak. -->
		
		{{-- Hidden fields for combo products --}}
		@if($product->product_type == 'combo')

			@foreach($product->combo_products as $k => $combo_product)

				@if(isset($action) && $action == 'edit')
					@php
						$combo_product['qty_required'] = $combo_product['quantity'] / $product->quantity_ordered;

						$qty_total = $combo_product['quantity'];
					@endphp
				@else
					@php
						$qty_total = $combo_product['qty_required'];
					@endphp
				@endif

				<input type="hidden" 
					name="products[{{$row_count}}][combo][{{$k}}][product_id]"
					value="{{$combo_product['product_id']}}">

					<input type="hidden" 
					name="products[{{$row_count}}][combo][{{$k}}][variation_id]"
					value="{{$combo_product['variation_id']}}">

					<input type="hidden"
					class="combo_product_qty" 
					name="products[{{$row_count}}][combo][{{$k}}][quantity]"
					data-unit_quantity="{{$combo_product['qty_required']}}"
					value="{{$qty_total}}">

					@if(isset($action) && $action == 'edit')
						<input type="hidden" 
							name="products[{{$row_count}}][combo][{{$k}}][transaction_sell_lines_id]"
							value="{{$combo_product['id']}}">
					@endif

			@endforeach
		@endif
		</div>
	</td>
	<td class="goster text-center" style="display:none">
        <span>@lang('sale.qty_available') {{$product->qty_available}} {{$product->unit}}</span>
    </td>
	@if(!empty($pos_settings['inline_service_staff']) && !empty($waiters))
		<td class="no-print">
			<div class="form-group">
				<div class="input-group">
					{!! Form::select("products[" . $row_count . "][res_service_staff_id]", $waiters, !empty($product->res_service_staff_id) ? $product->res_service_staff_id : null, ['class' => 'form-control select2 order_line_service_staff', 'placeholder' => __('restaurant.select_service_staff'), 'required' => (!empty($pos_settings['is_service_staff_required']) && $pos_settings['is_service_staff_required'] == 1) ? true : false ]); !!}
				</div>
			</div>
		</td>
	@endif
	<td class="{{$hide_tax}} no-print">
		<input type="text" name="products[{{$row_count}}][unit_price_inc_tax]" class="form-control pos_unit_price_inc_tax unit_price_prod_{{$prod_id}} input_number" value="{{@num_format($unit_price_inc_tax)}}" @if(!$edit_price) readonly @endif @if(!empty($pos_settings['enable_msp'])) data-rule-min-value="{{$unit_price_inc_tax}}" data-msg-min-value="{{__('lang_v1.minimum_selling_price_error_msg', ['price' => @num_format($unit_price_inc_tax)])}}" @endif>
	</td>
	<td class="text-center v-center no-print">
		@php
			$subtotal_type = !empty($pos_settings['is_pos_subtotal_editable']) ? 'text' : 'hidden';

		@endphp
		<input type="{{$subtotal_type}}" class="form-control pos_line_total @if(!empty($pos_settings['is_pos_subtotal_editable'])) input_number @endif" value="{{@num_format($product->quantity_ordered*$unit_price_inc_tax )}}">
		<span class="line_total_price_prod_{{$prod_id}} display_currency pos_line_total_text @if(!empty($pos_settings['is_pos_subtotal_editable'])) hide @endif" data-currency_symbol="true">{{$product->quantity_ordered*$unit_price_inc_tax}}</span>
	</td>
	<td class="text-center no-print">
		<i class="fa fa-times text-danger pos_remove_row cursor-pointer no-print remove_cs_{{$prod_id}}" aria-hidden="true"></i>
	</td>
</tr>
<tr class="cs_product_row" id="cs_prd_{{$prod_id}}" style="display:none">
    <td>
        {{$product->product_name}}
    </td>
    <td>
        <span class="cs_qty_prod_{{$prod_id}}"></span> <span>{{$product->unit}}</span>
    </td>
    <td>
        <span class="cs_unit_price_prod_{{$prod_id}}">{{@num_format($unit_price_inc_tax)}}</span>
    </td>
    <td>
        <span class="cs_line_total_price_prod_{{$prod_id}}">{{$product->quantity_ordered*$unit_price_inc_tax}}</span>
    </td>
</tr>
<script>
    $('.remove_cs_{{$prod_id}}').on('click', function(e){
           $('#cs_prd_{{$prod_id}}').remove();
       });
    $('.pos-express-finalize').on('click', function(e){
           $('#cs_prd_{{$prod_id}}').remove();
       });
    $('#pos-save').on('click', function(e){
           $('#cs_prd_{{$prod_id}}').remove();
       });
    $('#pos-save-card').on('click', function(e){
           $('#cs_prd_{{$prod_id}}').remove();
       });
    $('#pos-quotation').on('click', function(e){
           $('#cs_prd_{{$prod_id}}').remove();
       });   
    $('#pos-draft').on('click', function(e){
           $('#cs_prd_{{$prod_id}}').remove();
       }); 
    $('#pos-cancel').on('click', function(e){
           $('#cs_prd_{{$prod_id}}').remove();
       }); 
    
       
       
     
    setInterval(function(){
       $(".cs_qty_prod_{{$prod_id}}").html($(".prod_{{$prod_id}}").val());
       $(".cs_unit_price_prod_{{$prod_id}}").html($(".unit_price_prod_{{$prod_id}}").val());
       $(".cs_line_total_price_prod_{{$prod_id}}").html($(".line_total_price_prod_{{$prod_id}}").html());
    },500);
</script>
</body>
</html>