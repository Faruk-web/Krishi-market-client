@extends('backend.layouts.app')
@section('content')
  
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>  
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <style>

.modal-confirm {		
	color: #636363;
	width: 400px;
}
.modal-confirm .modal-content {
	padding: 20px;
	border-radius: 5px;
	border: none;
	text-align: center;
	font-size: 14px;
}
.modal-confirm .modal-header {
	border-bottom: none;   
	position: relative;
}
.modal-confirm h4 {
	text-align: center;
	font-size: 26px;
	margin: 30px 0 -10px;
}
.modal-confirm .close {
	position: absolute;
	top: -5px;
	right: -2px;
}
.modal-confirm .modal-body {
	color: #999;
}
.modal-confirm .modal-footer {
	border: none;
	text-align: center;		
	border-radius: 5px;
	font-size: 13px;
	padding: 10px 15px 25px;
}
.modal-confirm .modal-footer a {
	color: #999;
}		
.modal-confirm .icon-box {
	width: 80px;
	height: 80px;
	margin: 0 auto;
	border-radius: 50%;
	z-index: 9;
	text-align: center;
	border: 3px solid #f15e5e;
}
.modal-confirm .icon-box i {
	color: #f15e5e;
	font-size: 46px;
	display: inline-block;
	margin-top: 13px;
}
.modal-confirm .btn, .modal-confirm .btn:active {
	color: #fff;
	border-radius: 4px;
	background: #60c7c1;
	text-decoration: none;
	transition: all 0.4s;
	line-height: normal;
	min-width: 120px;
	border: none;
	min-height: 40px;
	border-radius: 3px;
	margin: 0 5px;
}
.modal-confirm .btn-secondary {
	background: #c1c1c1;
}
.modal-confirm .btn-secondary:hover, .modal-confirm .btn-secondary:focus {
	background: #a8a8a8;
}
.modal-confirm .btn-danger {
	background: #f15e5e;
}
.modal-confirm .btn-danger:hover, .modal-confirm .btn-danger:focus {
	background: #ee3535;
}
.trigger-btn {
	display: inline-block;
	margin: 100px auto;
}
</style>
@php

    $point = DB::table('pointconfigs')->first();
    
   
@endphp
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6">{{translate('Product Discount Config')}}</h5>
                </div>
                <div class="card-body">
                   <form class="form-horizontal" action="{{ route('discount.add') }}" method="POST">  
                   @csrf
                    <input type="hidden" name="product_id" value={{$pid}}>

            <div class="table-responsive">  
                <table class="table table-bordered" id="dynamic_field">  
                    <tr>  
                        <td><input type="text" name="start_qty[]" placeholder="Start Quentity" class="form-control name_list" /></td>  
                        <td><input type="text" name="end_qty[]" placeholder="End Quentity" class="form-control name_list" /></td>
                        <td><select name="type[]" class="form-control">
                            <option selected disabled>Select Discount Type</option>
                            <option>Flat</option>
                            <option>Percentage</option>
                        </select></td>  
                        <td><input type="text" name="discount[]" placeholder="discount" class="form-control name_list" /></td>  
                        
                        <td><button type="button" name="add" id="add" class="btn btn-success">Add More</button></td>  
                    </tr>  
                </table>  
                <button  type="submit"  class="btn btn-info">Submit</button>
                <!--<input value="Submit" />  -->
            </div>


         </form>  
                   
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
              <div class="card">
                <div class="card-header">
           <table id="example" class="table table-striped" style="width:100%">
        <thead>
            <tr>
                <th>Quentity</th>
                <th>Discount</th>
                <th>Type</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($discountconfig as $discount)
            <tr>
                <td>{{$discount->start_qty}} - {{$discount->end_qty}} </td>
                <td>{{$discount->discount}}</td>
                <td>{{$discount->type}}</td>
               
               
                <td>
                    <a data-id="{{$discount->id}}" class="btn btn-primary btn-sm editProduct"> <i class="las la-edit"></i></a>
                    <a data-id="{{$discount->id}}" href="#myModal"  data-toggle="modal" class="btn btn-danger btn-sm deleteProduct"> <i class="las la-trash"></i></a>
                </td>
            </tr>
       @endforeach
      
        </tbody>
  
    </table>
    </div>
    </div>
        </div>
        
        
        <div class="modal fade" id="ajaxModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading">Update Discount</h4>
            </div>
            <div class="modal-body">
                <form action="{{ route('discount.update') }}" method="POST">
                    @csrf
                   <input type="hidden" name="discount_id" id="discount_id">
                   <div class="row">
                       <div class="col-md-6"><div class="form-group">
                        <label for="name" class="col-sm-2 control-label">start Quentity</label>
                        <div class="col-sm-12">
                            <input type="number" class="form-control" id="start_qty" name="start_qty" placeholder="Enter Name" value="" maxlength="50" required="">
                        </div>
                    </div></div>
                       <div class="col-md-6"><div class="form-group">
                        <label for="name" class="col-sm-2 control-label">End Quentity</label>
                        <div class="col-sm-12">
                            <input type="number" class="form-control" id="end_qty" name="end_qty" placeholder="Enter Name" value="" maxlength="50" required="">
                        </div>
                    </div></div>
                   </div>
                    
     
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Discount</label>
                        <div class="col-sm-12">
                            <textarea id="discount" name="discount" required="" placeholder="Enter Details" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="col-sm-offset-2 col-sm-10">
                     <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Save changes
                     </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>




<!-- Modal HTML -->
<div id="myModal" class="modal fade">
	<div class="modal-dialog modal-confirm">
		<div class="modal-content">
			<div class="modal-header flex-column">
				<div class="icon-box">
					<i class="material-icons">&#xE5CD;</i>
				</div>						
				<h4 class="modal-title w-100">Are you sure?</h4>	
				
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>
			<form action="{{ route('discount.delete') }}" method="POST">
                    @csrf
                    <input type="hidden" name="delete_id" id="delete_id">
			<div class="modal-body">
				<p>Do you really want to delete these records? This process cannot be undone.</p>
			</div>
			<div class="modal-footer justify-content-center">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
				<button type="submit" class="btn btn-danger">Delete</button>
			</div>
		</div>
		</form>
	</div>
</div>     
      
    </div>
    

    
<script type="text/javascript">
    $(document).ready(function(){      
      var postURL = "<?php echo url('addmore'); ?>";
      var i=1;  


      $('#add').click(function(){  
           i++;  
           $('#dynamic_field').append('<tr id="row'+i+'" class="dynamic-added"><td><input type="text" name="start_qty[]" placeholder="Start Quentity" class="form-control name_list" /></td><td><input type="text" name="end_qty[]" placeholder="End Quentity" class="form-control name_list" /></td><td><select name="type[]" class="form-control"> <option selected disabled>Select Discount Type</option><option>Flat</option><option>Percentage</option> </select></td><td><input type="text" name="discount[]" placeholder="discount" class="form-control name_list" /></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');  
      });  


      $(document).on('click', '.btn_remove', function(){  
           var button_id = $(this).attr("id");   
           $('#row'+button_id+'').remove();  
      });  


    }); 
    
    
</script>
<script>
   $(function () {
         $('body').on('click', '.editProduct', function () {
      var discount_id = $(this).data('id');
      console.log(discount_id);
       $.ajax({
            type: "GET",
            url: "/admin/discount/edit/"+discount_id,
            success: function (data) {
              $('#discount_id').val(data.id);
              $('#start_qty').val(data.start_qty);
              $('#end_qty').val(data.end_qty);
              $('#discount').val(data.discount);
              $('#type').val(data.type);
               $('#ajaxModel').modal('show');
            },
            error: function (data) {
             
            }
        });
   });
   })
   
     $('body').on('click', '.deleteProduct', function () {
     
        var product_id = $(this).data("id");
         $('#delete_id').val(product_id);
         console.log(product_id);
        <!--$.ajax({-->
        <!--    type: "GET",-->
        <!--    url: "/admin/discount/delete/"+product_id,-->
        <!--    success: function (data) {-->
             
        <!--    },-->
        <!--    error: function (data) {-->
        <!--        console.log('Error:', data);-->
        <!--    }-->
        <!--});-->
    });
</script>
@endsection
