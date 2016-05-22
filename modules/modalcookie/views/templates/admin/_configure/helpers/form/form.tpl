{extends file="helpers/form/form.tpl"}
{block name="leadin"}
		<fieldset style="width: 300px;float:right;margin-left:15px;margin-top:10px;">
			<legend><img src="../img/admin/information.png"/> {l s='Информация' mod='blockcomments'}</legend>
			<div id="dev_div">
			    <p><a href="http://webnewbie.ru/"><img src="{$this_path}logo.png" alt="{l s='Бесплатные модули и шаблоны для PrestaShop' mod='blockcomments'}"/></a></p>
				<span><strong>{l s='Версия' mod='blockcomments'}: </strong>{$version}</span><br>
				<span><strong>{l s='Разработка' mod='blockcomments'}:</strong> <a class="link" href="mailto:dulco@webnewbie.ru" target="_blank">{$author}</a><br>
				<span><strong>{l s='Ресурс' mod='blockcomments'}:</strong> <a class="link" href="http://webnewbie.ru/" target="_blank">webnewbie.ru</a><br>
				
			<p><strong>Поблагодарить можно и так:</strong></p><iframe frameborder="0" allowtransparency="true" scrolling="no" src="https://money.yandex.ru/embed/small.xml?account=41001507750418&quickpay=small&any-card-payment-type=on&button-text=06&button-size=s&button-color=orange&targets=%D0%BF%D0%BE%D0%BC%D0%BE%D1%89%D1%8C+%D0%BF%D1%80%D0%BE%D0%B5%D0%BA%D1%82%D1%83+webnewbie.ru&default-sum=50" width="146" height="31"></iframe>
			</strong></p><iframe  frameborder="0" allowtransparency="true" scrolling="no" src="https://money.yandex.ru/embed/small.xml?uid=41001507750418&amp;button-text=06&amp;button-size=s&amp;button-color=orange&amp;targets=%D0%9F%D0%BE%D0%B1%D0%BB%D0%B0%D0%B3%D0%BE%D0%B4%D0%B0%D1%80%D0%B8%D1%82%D1%8C+%D0%BC%D0%BE%D0%B6%D0%BD%D0%BE+%D0%B8+%D1%82%D0%B0%D0%BA&amp;default-sum=50&amp;mail=on" width="auto" height="31"></iframe>
			<p><strong>WMR-кошелёк: R256926392660</p></strong>
			<p><strong>WMZ-кошелёк: Z154043439842</p></strong>
			
			
			</div>
		</fieldset>
		
{/block}