<?php if ( isset( $fields ) && is_array( $fields ) ) : ?>
	<section class="faq <?php echo strtolower( $fields['mode'] ); ?>">
		<div class="container">
			<div class="faq__tabs">
				<?php if ( !empty( $fields['title'] ) ) : ?>
					<h4 class="faq__title"><?php echo $fields['title'] ?></h4>
				<?php endif; ?>
				<?php if ( !empty( $fields['tabs'] ) ) : ?>
					<div class="faq__desktop-only">
						<?php foreach ( $fields['tabs'] as $key=>$tab ): ?>
							<?php if ( !empty( $tab['tab_title'] ) ) : ?>
								<h5 class="faq__tab" data-faq-tab="<?php echo $key ?>" class="faq__tab"><?php echo $tab['tab_title'] ?></h5>
							<?php endif; ?>
						<?php endforeach; ?>
					</div>
					<div class="faq__mobile-only">
						<div class="location-select">
							<div id="faq-selected" class="dropdown-trigger location-dropdown__trigger" data-toggle="location-select__menu-pane-0"><span><?php echo reset( $fields['tabs'] )['tab_title']; ?></span>
								<div id="location-select__menu-pane-0" class="js-location-select-menu-pane dropdown-pane" data-dropdown data-position="bottom" data-alignment="right" data-v-offset="0" data-close-on-click="true">
									<ul class="location-select__list">
										<?php foreach ( $fields['tabs'] as $key=>$tab ) : ?>
											<?php echo '<li><a data-value="' . $key . '">' . $tab['tab_title'] . '</a></li>'; ?>
										<?php endforeach; ?>
									</ul>
									<form class="hidden">
										<select id="faq-select" name="faqs">
											<?php foreach ( $fields['tabs'] as $key=>$tab ) : ?>
												<?php echo '<option value="' . $key . '">' . $tab['tab_title'] . '</option>'; ?>
											<?php endforeach; ?>
										</select>
									</form>
								</div>
							</div>
						</div>
					</div>
				<?php endif; ?>
			</div>
			<div class="faq__list-container">
				<?php if ( !empty( $fields['tabs'] ) ) : ?>
					<?php foreach ( $fields['tabs'] as $key=>$tab ) : ?>
						<div class="faq__list" id="faq-list-<?php echo $key ?>">
							<?php if ( !empty( $tab['item'] ) ) : ?>
								<?php foreach ( $tab['item'] as $index=>$item ): ?>
									<div class="faq__list-item">
										<input
											class="faq__list-item-checkbox"
											type="checkbox" id="faq-list-<?php echo $key ?>-item-<?php echo $index ?>" />
										<div class="faq__list-item-content">
											<label class="faq__list-item-label" for="faq-list-<?php echo $key ?>-item-<?php echo $index ?>">
												<div class="faq__icon">
													<span class="faq__icon--one"></span>
													<span class="faq__icon--two"></span>
												</div>
												<?php if ( !empty( $item['question'] ) ) : ?>
													<h5 class="faq__question"><?php echo $item['question'] ?></h5>
												<?php endif; ?>
											</label>
											<?php if ( !empty( $item['answer'] ) ) : ?>
												<div class="faq__answer wysiwyg"><?php echo $item['answer'] ?></div>
											<?php endif; ?>
										</div>
									</div>
								<?php endforeach; ?>
							<?php endif; ?>
						</div>
					<?php endforeach; ?>
				<?php endif; ?>
			</div>
		</div>
	</section>
<?php endif; ?>
