@extends('layouts.app')

@section('content')
<style type="text/css">
	.lili{
		list-style-type: none;
	}
</style>
<div class="row">
	<div class="col-xl-12">
		<div class="card" style="zoom: 1;">
			<div class="card-header header-elements-inline">
				<h5 class="card-title">{{ $title }}</h5>
			</div>

			<div class="card-body">
				<div id="frame-detail">
					<div class="table-responsive">
<form class="form-validate-jquery" id="form-data" action="#">
<!--<form class="form-validate-jquery" method="POST" id="form-data" novalidate action="{{ url('sistem/autorisasi/role-menu/') }}">-->
	@csrf 
	<div class="row">
		<div class="col-md-6">
			<div class="form-group form-group-float">
				<label class="form-group-float-label is-visible">Kode Autorisasi <span class="text-danger">*</span></label>
				<input type="text" name="role_cd_detail" class="form-control" required="" placeholder="" aria-invalid="false" readonly value="{{ $role->role_cd }}">
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group form-group-float">
				<label class="form-group-float-label is-visible">Nama Autorisasi <span class="text-danger">*</span></label>
				<input type="text" name="role_nm" class="form-control" required="" placeholder="" aria-invalid="false" value="{{ $role->role_nm }}">
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<div class="form-group pt-2">
				<label class="font-weight-semibold">Hak Akses</label>
				<div class="form-check">
					<label class="form-check-label">
						<input type="checkbox" class="form-check-input-styled" data-fouc name="create" @if (substr($role->rule_tp,0,1) == '1') checked @else @endif value="C">
						Create
					</label>
				</div>
				<div class="form-check">
					<label class="form-check-label">
						<input type="checkbox" class="form-check-input-styled" data-fouc name="read" @if (substr($role->rule_tp,1,1) == '1') checked @else @endif value="R">
						Read
					</label>
				</div>
				<div class="form-check">
					<label class="form-check-label">
						<input type="checkbox" class="form-check-input-styled" data-fouc name="update" @if (substr($role->rule_tp,2,1) == '1') checked @else @endif value="U">
						Update
					</label>
				</div>
				<div class="form-check">
					<label class="form-check-label">
						<input type="checkbox" class="form-check-input-styled" data-fouc name="delete" @if (substr($role->rule_tp,3,1) == '1') checked @else @endif value="D">
						Delete
					</label>
				</div>
			</div>
		</div>
	</div>
	
	<label class="font-weight-semibold">Menu</label>
	<!--
	<br><input type="checkbox" name="role_menu_all" id="role_menu_all" class="form-check-input-styled"><br>
	<script type="text/javascript">
		$(document).ready(function(){
			$("#role_menu_all").click(function(){
				var checked_status = this.checked;
				$("input[name=oto[]]").each(function(){
					this.checked = checked_status;
				});
			});
		
		});
	</script>
	-->
	<input type="hidden" name="role_cd" value="{{ $role->role_cd }}">
	<?php foreach ($data['menu_level_1'] as $menu1) { ?>
		<?php if (!empty($data['menu_level_2'])) { ?>
		<!-- start menu level 1 -->
		<li class="lili">
			<div class="form-check form-check-inline">
				<label class="form-check-label">
					<input type="checkbox" class="form-check-input-styled" name="oto[]" value="{{ $menu1->menu_cd }}" {{ $menu1->status }} data-fouc>
					{{ $menu1->menu_nm }}
				</label>
			</div>

			<!-- start menu level 2 -->
			<ul class="lili">
			<?php foreach ($data['menu_level_2'] as $menu2) {?>
				<?php if (!empty($data['menu_level_3'])) { ?>
					<?php if ($menu2->menu_root == $menu1->menu_cd) { ?>
					<li class="lili">
						<div class="form-check form-check-inline">
							<label class="form-check-label">
								<input type="checkbox" class="form-check-input-styled" name="oto[]" value="{{ $menu2->menu_cd }}" {{ $menu2->status }} data-fouc>
								{{ $menu2->menu_nm }}
							</label>
						</div>
						
						<!-- start menu level 3 -->
						<ul class="lili">
						<?php foreach ($data['menu_level_3'] as $menu3) {?>
							<?php if (!empty($data['menu_level_4'])) { ?>
								<?php if ($menu3->menu_root == $menu2->menu_cd) { ?>
								<li class="lili">
									<div class="form-check form-check-inline">
										<label class="form-check-label">
											<input type="checkbox" class="form-check-input-styled" name="oto[]" value="{{ $menu3->menu_cd }}" {{ $menu3->status }} data-fouc>
											{{ $menu3->menu_nm }}
										</label>
									</div>
									
									<!-- start menu level 4 -->
									<ul class="lili">
									<?php foreach ($data['menu_level_4'] as $menu4) {?>
										<?php if (!empty($data['menu_level_5'])) { ?>
											<?php if ($menu4->menu_root == $menu3->menu_cd) { ?>
												<li class="lili">
													<div class="form-check form-check-inline">
														<label class="form-check-label">
															<input type="checkbox" class="form-check-input-styled" name="oto[]" value="{{ $menu4->menu_cd }}" {{ $menu4->status }} data-fouc>
															{{ $menu4->menu_nm }}
														</label>
													</div>
												</li>
											<?php }  ?>
										<?php }else{ ?>
											<?php if ($menu4->menu_root == $menu3->menu_cd) { ?>
												<li class="lili">
													<div class="form-check form-check-inline">
														<label class="form-check-label">
															<input type="checkbox" class="form-check-input-styled" name="oto[]" value="{{ $menu4->menu_cd }}" {{ $menu4->status }} data-fouc>
															{{ $menu4->menu_nm }}
														</label>
													</div>
												</li>
											<?php } ?>
										<?php } ?>
									<?php } ?>
									</ul>
									<!-- end menu level 4 -->
								</li>
								<?php }  ?>
							<?php }else{ ?>
								<?php if ($menu3->menu_root == $menu2->menu_cd) { ?>
									<li class="lili">
										<div class="form-check form-check-inline">
											<label class="form-check-label">
												<input type="checkbox" class="form-check-input-styled" name="oto[]" value="{{ $menu3->menu_cd }}" {{ $menu3->status }} data-fouc>
												{{ $menu3->menu_nm }}
											</label>
										</div>
									</li>
								<?php } ?>
							<?php } ?>
						<?php } ?>
						</ul>
						<!-- end menu level 3 -->
					</li>
					<?php }  ?>
				<?php }else{ ?>
					<?php if ($menu2->menu_root == $menu1->menu_cd) { ?>
					<li class="lili">
						<div class="form-check form-check-inline">
							<label class="form-check-label">
								<input type="checkbox" class="form-check-input-styled" name="oto[]" value="{{ $menu2->menu_cd }}" {{ $menu2->status }} data-fouc>
								{{ $menu2->menu_nm }}
							</label>
						</div>
					</li>
					<?php } ?>
				<?php } ?>
			<?php } ?>
			</ul>
			<!-- end menu level 2 -->
		</li>
		<?php }else{ ?>
			<li class="lili">
				<div class="form-check form-check-inline">
					<label class="form-check-label">
						<input type="checkbox" class="form-check-input-styled" name="oto[]" value="{{ $menu1->menu_cd }}" {{ $menu1->status }} data-fouc>
						{{ $menu1->menu_nm }}
					</label>
				</div>
			</li>
		<?php } ?>
	<?php } ?>
	<div class="d-flex justify-content-end align-items-center">
		<button type="submit" class="btn btn-primary legitRipple">Simpan <i class="icon-floppy-disk ml-2"></i></button>
		<button type="reset" class="btn btn-light ml-2 legitRipple" id="reset">Selesai <i class="icon-reload-alt ml-2"></i></button>
	</div>
</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@push('scripts')
<script>
    var tabelData;
    var tabelMenu;
	var baseUrl = '{{ url("sistem/admin/autorisasi/") }}';

    $(document).ready(function(){
        $('.check').uniform();
        $('.form-check-input-styled').uniform();
        
		//--Reset form
        $('#reset').click(function(){
			window.location = baseUrl;
        });
        
        //--Submit form
        $('#form-data').submit(function(e){
			if (e.isDefaultPrevented()) {
            //--Handle the invalid form
            } else {
                e.preventDefault();
                var record=$('#form-data').serialize();
				var url     = baseUrl + '/' + '{{ $role->role_cd }}';
                var method  = 'PUT';

                swal({
                    title               : 'Simpan Data?',
                    type                : "question",
                    showCancelButton    : true,
                    confirmButtonColor  : "#00a65a",
                    confirmButtonText   : "OK",
                    cancelButtonText    : "NO",
                    allowOutsideClick : false,
                }).then(function(result){
                    if(result.value){
                        swal({allowOutsideClick : false,title: "Proses simpan",onOpen: () => {swal.showLoading();}});

                        $.ajax({
                            'type': method,
                            'url' : url,
                            'data': record,
                            'dataType': 'JSON',
                            'success': function(response){
                                if(response["status"] == 'ok') {     
                                    swal({
                                        title: "Proses berhasil",
                                        type: "success",
                                        showCancelButton: false,
                                        showConfirmButton: false,
                                        timer: 1000
                                    }).then(() => {
                                        //$('#reset').click();
										swal.close();
                                    });
                                }else{
                                    swal({title: "Proses gagal",type: "error",showCancelButton: false,showConfirmButton: false,timer: 1000});
                                }
                            },
                            'error': function(response){ 
                                var errorText = '';
                                $.each(response.responseJSON.errors, function(key, value) {
                                    errorText += value+'<br>'
                                });

                                swal({
                                    title             : response.status+':'+response.responseJSON.message,
                                    type              : "error",
                                    html              : errorText, 
                                    showCancelButton  : false,
                                    confirmButtonColor: "#DD6B55",
                                    confirmButtonText : "OK",
                                    cancelButtonText  : "NO",
                                }).then(function(result){
                                    if(result.value){   	
                                        reset('ubah');
                                    }
                                });  
                            }
                        });
                    }
                });
            }
        });
    });
</script>
@endpush