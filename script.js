<script>
	function jam(){
		var waktu = new Date();
		var jam = waktu.getHours();
		var menit = waktu.getMinutes();
		var detik = waktu.getSeconds();
		 
		if (jam < 10){ jam = "0" + jam; }
		if (menit < 10){ menit = "0" + menit; }
		if (detik < 10){ detik = "0" + detik; }
		var jam_div = document.getElementById('jam');
		jam_div.innerHTML = jam + ":" + menit + ":" + detik;
		setTimeout("jam()", 1000);
	} jam();
	
	$(document).ready(function () {
		
		$('#menu_nestable').nestable({
			 maxDepth:3,
		}).on('change',function() {
			updateOutput($('#menu_nestable').data('output', $('#menu_nestable_output')));
		});
	  
		var last_touched = '';
		var updateOutput = function (e) 
		{
			var list = e.length ? e : $(e.target),
				output = list.data('output');

			if (window.JSON) {
				output.val(window.JSON.stringify(list.nestable('serialize'))); //, null, 2));

				$.post('<?=site_url('menu/update_struktur');?>', 
					{ 'whichnest' : last_touched, 'output' : output.val() }, 
					function(data) {
						console.log('success')
					}
				);

			}
			 else {
				output.val('JSON browser support required for this demo.');
			}
		};

		$('#nestable_list_menu').on('click', function (e) {
			var target = $(e.target),
				action = target.data('action');
			if (action === 'expand-all') {
				$('.dd').nestable('expandAll');
			}
			if (action === 'collapse-all') {
				$('.dd').nestable('collapseAll');
			}
		});

	});

	$(document).ready(function(){
		$('#formmenucustom').submit(function(e){
			e.preventDefault();
			$.ajax({
				url : $(this).attr('action'),
				type: "post",
				data : $(this).serialize(),
				error: function (xhr, ajaxOptions, thrownError) {
					return false;		  	
				},
				success:function(){
					 $("#formmenucustom").each(function(){
						this.reset();
					});
					 
					$('#menu_nestable').load("<?=site_url('menu/tampilprimarymenu');?>");
				}
			});
			
		});
		$(".tambahkan-ke-menu").click(function(event){
			var	nama_menu 	=$(this).attr("data-title");
			var	url_menu  	=$(this).attr("data-url");
			var	type_menu  	=$(this).attr("data-type");
			
			 $.ajax({
				type:"POST",
				url:"<?=site_url('menu/insertmenu');?>",
				data:{"nama":nama_menu,"url":url_menu,"type":type_menu},
				cache: false,
				dataType:"json",
				success: function(){
					$('#menu_nestable').load("<?=site_url('menu/tampilprimarymenu');?>");
				},
				error: function(a,b,c){
					console.log(a.responseText);
					console.log(c);
				}
			});
		});
		
	});

	function hapusmenuid(id) {
		if(confirm('Apakah anda yakin mau menghapus data ini?')){
			$.ajax({
				type: 'POST',
				url: '<?=site_url('menu/hapusmenuid');?>',
				data: 'id='+id,
				error: function (xhr, ajaxOptions, thrownError) {
					return false;		  	
				},
				success: function () {
					$('#menu_nestable').load("<?=site_url('menu/tampilprimarymenu');?>");
				}
			});
		}
	};


</script>