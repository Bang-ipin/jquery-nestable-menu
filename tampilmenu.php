<?php 
$menulib = new menu_lib();
?>
<div class="portlet-body">
	<div class="dd" id="menu_nestable">
		<ol class="dd-list">
			<?php 
			$query= $menulib->getPrimaryMenu();
			foreach ($query->result_array() as $menu) : 
			$menu_id=$menu['id_menu'];
			$child_satu = $menulib->getMenuChild($menu_id);
			if($child_satu->num_rows() == 0){ ?>
			<li class="dd-item dd3-item" data-id="<?=$menu_id;?>">
				<div class="dd-handle dd3-handle"></div>
				<div class="dd3-content">
					 <?=$menu['nama_menu'];?>
					 <a href="javascript:void(0)" onclick="hapusmenuid('<?=$menu_id;?>');" class="pull-right"><i class="fa fa-trash"></i></a>
				</div>
			</li>
			<?php }else{ ?>
			<li class="dd-item dd3-item" data-id="<?=$menu_id;?>">
				<div class="dd-handle dd3-handle"></div>
				<div class="dd3-content">
					 <?=$menu['nama_menu'];?>
					 <a href="javascript:void(0)" onclick="hapusmenuid('<?=$menu_id;?>');" class="pull-right"><i class="fa fa-trash"></i></a>
				</div>
				<?php if($menulib->getMenuChild($menu_id)) : ?>
				<ol class="dd-list">
					<?php 
					$child_satu = $menulib->getMenuChild($menu_id);
                        foreach ($child_satu->result_array() as $child1) :
                        $menu_id2=$child1['id_menu'];
                        $child_dua = $menulib->getMenuChild($menu_id2);
                  	 if($child_dua->num_rows() == 0){
                    ?>
                    <li class="dd-item dd3-item" data-id="<?=$menu_id2;?>">
						<div class="dd-handle dd3-handle"></div>
						<div class="dd3-content">
							 <?=$child1['nama_menu'];?>
							 <a href="javascript:void(0)" onclick="hapusmenuid('<?=$menu_id2;?>');" class="pull-right"><i class="fa fa-trash"></i></a>
						</div>
					</li>
					<?php }else{ ?>
					<li class="dd-item dd3-item" data-id="<?=$menu_id2;?>">
						<div class="dd-handle dd3-handle"></div>
						<div class="dd3-content">
							 <?=$child1['nama_menu'];?>
							 <a href="javascript:void(0)" onclick="hapusmenuid('<?=$menu_id2;?>');" class="pull-right"><i class="fa fa-trash"></i></a>
						</div>
						<?php if($menulib->getMenuChild($menu_id2)) : ?>
							<ol class="dd-list">
								<?php
	                            $child_dua = $menulib->getMenuChild($menu_id2);
	                            foreach ($child_dua->result_array() as $child2) :
	                            $menu_id3=$child2['id_menu'];
	                            ?>
	                            <li class="dd-item dd3-item" data-id="<?=$menu_id3;?>">
									<div class="dd-handle dd3-handle"></div>
									<div class="dd3-content">
										 <?=$child2['nama_menu'];?>
										 <a href="javascript:void(0)" onclick="hapusmenuid('<?=$menu_id3;?>');" class="pull-right"><i class="fa fa-trash"></i></a>
									</div>
								</li>
								<?php endforeach; ?>
							</ol>
						<?php endif;?>
					</li>
					<?php } endforeach;?>
				</ol>
				<?php endif;?>
			</li>
			<?php } endforeach; ?>
		</ol>
	</div>
</div>