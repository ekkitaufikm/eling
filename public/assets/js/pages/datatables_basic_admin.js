/* ------------------------------------------------------------------------------
*
*  # Basic datatables
*
*  Specific JS code additions for datatable_basic.html page
*
*  Version: 1.0
*  Latest update: Aug 1, 2015
*
* ---------------------------------------------------------------------------- */

$(function() {


    // Table setup
    // ------------------------------

    // Setting datatable defaults
    $.extend( $.fn.dataTable.defaults, {
        autoWidth: false,
        columnDefs: [{ 
            orderable: false,
            width: '100%'
        }],
        dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
        language: {
            search: '<span>Cari:</span> _INPUT_',
            lengthMenu: '<span>Show:</span> _MENU_',
            paginate: { 'first': 'First', 'last': 'Last', 'next': '&rarr;', 'previous': '&larr;' }
        },
        drawCallback: function () {
            $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').addClass('dropup');
        },
        preDrawCallback: function() {
            $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').removeClass('dropup');
        }
    });


    // Basic datatable
	$('.datatable-basic').DataTable({
			"bProcessing": true,
			"serverSide": true,
			"ajax":{
				url :"response.php", // json datasource
				type: "post",  // type of method  ,GET/POST/DELETE
				error: function(){
				  $("#employee_grid_processing").css("display","none");
				}
			},
			"aoColumns": [
			  null,
			  null,
			  {
				"mData": "2",
				"mRender": function ( data, type, full ) {
					var nama_bulan=['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
					var tanggal=data.substr(8,2); 
					var bulan=data.substr(6,1); 
					if(bulan==12){
						var bulan_tampil=bulan;
					}
					else if(bulan==11){
						var bulan_tampil=data.substr(6,1);
					}
					else{
						var bulan_tampil=bulan;
					}
					var tahun=data.substr(0,4); 
					return tanggal+' '+nama_bulan[bulan_tampil-1]+' '+tahun;
					
				}
			  },
			  null,
			  {
				"mData": "4", <!-- Ini adalah untuk Link ID urutan kolom seperti table mulai dari 0 untuk data pertama -->
				"mRender": function ( data, type, full ) {
					return '<a href="data_arsip.php?page=editArsip&id='+data+'" class="btn btn-success btn-xs"><i class="icon-pen2"></i></a> <a href="#delModal" data-toggle="modal" data-id="'+data+'" class="hapus-modal btn btn-warning btn-xs"><i class="icon-bin"></i></a>';
					
				  }
			  }
			]
			
    });   

    // Alternative pagination
    $('.datatable-pagination').DataTable({
        pagingType: "simple",
        language: {
            paginate: {'next': 'Next &rarr;', 'previous': '&larr; Prev'}
        }
    });


    // Datatable with saving state
    $('.datatable-save-state').DataTable({
        stateSave: true
    });


    // Scrollable datatable
    $('.datatable-scroll-y').DataTable({
        autoWidth: true,
        scrollY: 300
    });



    // External table additions
    // ------------------------------

    // Add placeholder to the datatable filter option
    $('.dataTables_filter input[type=search]').attr('placeholder','Type to Search...');


    // Enable Select2 select for the length option
    $('.dataTables_length select').select2({
        minimumResultsForSearch: "-1"
    });
    
});
