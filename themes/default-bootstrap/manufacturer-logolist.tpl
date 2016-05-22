	<div class="manufacturers_frontlist row">
		{foreach from=$manufacturers item=manufacturer name=manufacturers}
			<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
				<div class="manufacturer-front-logo">
					{if isset($manufacturer.nb_products) && $manufacturer.nb_products > 0}
						<a
						class="lnk_img"
						href="{$link->getmanufacturerLink($manufacturer.id_manufacturer, $manufacturer.link_rewrite)|escape:'html':'UTF-8'}"
						title="{$manufacturer.name|escape:'html':'UTF-8'}" >
					{/if}
						<img src="{$img_manu_dir}{$manufacturer.image|escape:'html':'UTF-8'}-medium_default.jpg" alt="" />
					{if isset($manufacturer.nb_products) && $manufacturer.nb_products > 0}
						</a>
					{/if}
				</div>
			</div>
		{/foreach}
	</div>	
