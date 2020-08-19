<? include 'include/startpage.php'; ?>

<? include 'include/header.php'; ?>
		<?
			$link = explode('/', $_SERVER['REQUEST_URI']);
			$ABScreen = intval($link[1]);
if ($ABScreen == 1 or $ABScreen == 2) {
echo "<script>
window.location = '/';
</script>";
}
		?>
		<?// .first-screen ?>
		<div class="first-screen first-screen_<?=$ABScreen?>">
		    <div class="inner">
		        
		
		    	<div class="first-screen__title">
		    		Выдача займов до <span class="orange-txt">80% стоимости авто</span><br> под залог ПТС или автомобиля от 0,33% в сутки
		    	</div>

				
				<?// .first-screen__circs ?>
		    	<div class="first-screen__circs">
		    		
		    			<?// .circs ?>
			    		<div class="circs">

			    			<?// item ?>
			    			<div class="circs__item">
			    				<div class="circs__item-img">
			    					<i class="icon icon_time_money"></i>
			    				</div>
			    				<div class="circs__item-text">
			    					Выдача денег <br>
			    					в течение 30 минут
			    				</div>	
			    			</div>
			    			<?// item ?>

			    			<?// item ?>
			    			<div class="circs__item">
			    				<div class="circs__item-img">
			    					<i class="icon icon_hand_money"></i>
			    				</div>
			    				<div class="circs__item-text">
			    					Без дополнительных <br>
			    					комиссий и платежей
			    				</div>	
			    			</div>
			    			<?// item ?>

			    			<?// item ?>
			    			<div class="circs__item">
			    				<div class="circs__item-img">
			    					<i class="icon icon_evaluation"></i>
			    				</div>
			    				<div class="circs__item-text">
			    					Бесплатная оценка
			    				</div>	
			    			</div>
			    			<?// item ?>

			    		</div>
		    			<?// .circs ?>

		    	</div>
				<?// .first-screen__circs ?>



		    	<?// .first-screen__button ?>
		    	<div class="first-screen__button">
		    		<a href="#" class="btn open-popup" data-popup="order">Оставить заявку на займ</a>
		    	</div>
		    	<?// .first-screen__button ?>
		
		
		    </div>
		</div>
		<?// .first-screen ?>









		<?// .content ?>
		<div class="content">



			<?// .advantages ?>
			<section class="landingItem section advantages" id="advantages">

				<div class="advantages__title">
					<h2 class="h2 h2_orange">Ваши преимущества</h2>
				</div>

			    <div class="inner">
			        
			
				        <?// item  ?>
				        <div class="advantages__item">
				        
				        	<div class="advantages__item-title">
				        		1. Денежный займ легко получить
				        	</div>
				        
				        	<div class="advantages__item-text">
				        		Для оформления потребуется: паспорт, СОР, ПТС.
				        		<br>
				        		Кредитная история не учитывается, без справок и поручителей
				        	</div>
				        	
				        </div>
				        <?// item ?>
			        
			
				        <?// item  ?>
				        <div class="advantages__item">
				        
				        	<div class="advantages__item-title">
				        		2. Без дополнительных штрафов и комиссий
				        	</div>
				        
				        	<div class="advantages__item-text">
				        		Не берем штрафы за досрочное погашение займа (под ПТС).
				        		<br>
				        		Бесплатная охраняемая стоянка
				        	</div>
				        	
				        </div>
				        <?// item ?>
			        
			
				        <?// item  ?>
				        <div class="advantages__item">
				        
				        	<div class="advantages__item-title">
				        		3. Автомобиль остается у Вас
				        	</div>
				        
				        	<div class="advantages__item-text">
				        		Мы даем займы под залог ПТС,
				        		<br>
				        		а Вы можете пользоваться автомобилем
				        	</div>
				        	
				        </div>
				        <?// item ?>
			        
			
				        <?// item  ?>
				        <div class="advantages__item">
				        
				        	<div class="advantages__item-title">
				        		4. "Медведь" знают все
				        	</div>
				        
				        	<div class="advantages__item-text">
				        		Самый старый ломбард в Чите:
				        		<br>
				        		работаем с 2002 года, на рынке уже 15 лет
				        	</div>
				        	
				        </div>
				        <?// item ?>



				    	<?// .advantages__button ?>
				    	<div class="advantages__button">
				    		<a href="#" class="btn open-popup" data-popup="order">Оставить заявку на займ</a>
				    	</div>
				    	<?// .advantages__button ?>
			
			
			    </div>
			</section>
			<?// .advantages ?>

			<!-- calc -->
		  	<? include 'include/calc.php'; ?>
			<!-- /calc -->

			<?// .contacts ?>
			<section class="landingItem section contacts" id="contacts">

					<div class="contacts__title">
						<h2 class="h2 h2_orange">Наши контакты</h2>
					</div>


					<?// inner ?>
				    <div class="inner inner_start">
				        
							<div class="contacts__wrap">

								<?// item ?>
								<div class="contacts__item">
									г. Чита, ул. Рахова, 170
								</div>
								<?// item ?>

								<?// item ?>
								<div class="contacts__item">
									г. Чита, ул. Шилова, 35А
								</div>
								<?// item ?>

								<?// item ?>
								<div class="contacts__item">
									г. Чита, ул. Ленина, 149Б 
								</div>
								<?// item ?>

							</div>
				
				    </div>
					<?// inner ?>

					

					<?// .contacts__map ?>
					<div class="contacts__map">
						<script type="text/javascript" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?sid=_KQJVQPcnxBoT4dXiA4QYUNxF3uKoMhh&width=100%&height=400&lang=ru_RU&sourceType=constructor&scroll=false"></script>
					</div>
					<?// .contacts__map ?>
				    


					<?// inner ?>
				    <div class="inner inner_end">


				    		<div class="contacts__text">
				    			При необходимости, наш оценщик приедет к Вам 
				    			<br>
				    			в удобное для Вас время
				    		</div>
				        
					    	<?// .contacts__button ?>
					    	<div class="contacts__button">
					    		<a href="#" class="btn open-popup" data-popup="order">Оставить заявку на займ</a>
					    	</div>
					    	<?// .contacts__button ?>
				
				    </div>
					<?// inner ?>

			</section>
			<?// .contacts ?>

	        
	        <?// .section ?>
	        <section class="landingItem section section_orange" id="ask">

	        	<h2 class="h2">
	        		Остались вопросы?
	        	</h2>

	            <div class="inner inner_s">

	                
	        		<?// .form-box ?>
	                <div class="form-box">
	                	
	                	<div class="form-box__title">
	                		Задайте Ваш вопрос,
	                		<br>
	                		наш менеджер перезвонит и проконсультирует Вас
	                	</div>


	                	<form class="form form_tight">

	                		<div class="row row_inline-2">
	                			<input type="text" name="request[Имя]" placeholder="Ваше имя">
	                			<input type="phone" name="request[Телефон]" placeholder="Номер телефона">
	                			<input type="hidden" name="action" value="Остались вопросы">
	                			<input type="hidden" name="utm_medium" value="<?=$utm_source?>">
	                			<input type="hidden" name="utm_medium" value="<?=$utm_medium?>">
	                			<input type="hidden" name="utm_medium" value="<?=$utm_campaign?>">
	                			<input type="hidden" name="utm_medium" value="<?=$utm_term?>">
	                			<input type="hidden" name="utm_medium" value="<?=$utm_content?>">
	                			<input type="hidden" name="utm_medium" value="<?=$source?>">
	                			<input type="hidden" name="utm_medium" value="<?=$position?>">
	                		</div>

	                		<div class="row row_inline-2">
	                			<textarea name="request[Вопрос]" rows="10" placeholder="Ваш вопрос"></textarea>
	                		</div>

	                		<div class="row row_tac">
	                			<input type="submit" class="btn btn_outline-white" value="Задать вопрос">
	                		</div>

	                		<div class="row row_answer row_tac">
	                			<p class="error"></p>
	                		</div>
	                		
	                	</form>

	                </div>
	        		<?// .form-box ?>
	        
	        
	            </div>
	        </section>
	        <?// .section ?>


		</div>
		<?// .content ?>



<? include 'include/footer.php'; ?>

<? include 'include/endpage.php'; ?>