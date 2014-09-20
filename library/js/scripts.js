jQuery(document).ready(function($) {

	// ===== GLOBAL HELPER OBJECT
	// ================================================================================

	var globalHelper = {
		// Determines if an elements exists on the page
		elementExists: function(e) {
			if(e.length > 0) {
				return true;
			} else {
				return false;
			}
		}
	};



	// ===== SCROLL TO TARGET
	// ================================================================================

	var scrollTo = {
		settings: {
			trigger: $('.scrollto-link')
		},
		init: function() {
			this.bindUIActions();
		},
		bindUIActions: function() {
			this.settings.trigger.on('click', function() {
				scrollTo.scrollToTarget($(this).data('target'));
				return false;
			});
		},

		scrollToTarget: function(target) {
			$('html,body').animate({ scrollTop: $('a[name="'+target+'"]').offset().top }, 500);
		}
	};
	scrollTo.init();



	// ===== SINGLE PROJECT
	// ================================================================================

	var singleProject = {
		settings: {
			required_element: $('.pg-design-single'),
			comp_link: $('.design-set-comp-link'),
			scroll_timer: 0,
			// TODO - GIVE ME SOME COMMENTS ...
			sidebar: $('.col-sidebar'),
			sidebar_offset: 0,
			sidebar_height: 0,
			sidebar_margin: 0,
			sidebar_margin_default: 0,
			sidebar_padding: 15,
			body_col: $('.col-body'),
			body_col_height: 0,
			window_height: 0,
			window_scrolltop: 0
		},
		init: function() {
			if(globalHelper.elementExists(this.settings.required_element)) {
				this.bindUIActions();
				this.matchLinkHeights();
				// TODO - GIVE ME SOME COMMENTS ...
				this.settings.sidebar_offset = this.settings.sidebar.offset().top;
				this.settings.sidebar_margin_default = parseInt(this.settings.sidebar.css('marginTop'));
			}
		},
		bindUIActions: function() {
			$(window).scroll(function() {
				clearTimeout(singleProject.scroll_timer);
				singleProject.scroll_timer = setTimeout(function() { singleProject.positionSidebar() }, 250);
			});
		},

		// Modifies each design comp link so that they all have the same height.
		matchLinkHeights: function() {
			this.settings.comp_link.height(this.getMaxLinkHeight());
		},
		// Determines the largest design comp height.
		getMaxLinkHeight: function() {
			var maxHeight = 0;
			this.settings.comp_link.each(function() {
				if($(this).height() > maxHeight) {
					maxHeight = $(this).height();
				}
			});
			return maxHeight;
		},
		// Reposition the sidebar to stay with the user as the browser scrolls
		positionSidebar: function() {
			// TODO - GIVE ME SOME COMMENTS ...
			// TODO - GIVE ME SOME COMMENTS ...
			// TODO - GIVE ME SOME COMMENTS ...
			// TODO - GIVE ME SOME COMMENTS ...
			// TODO - GIVE ME SOME COMMENTS ...
			this.settings.sidebar_height = this.settings.sidebar.height();
			this.settings.body_col_height = this.settings.body_col.height();
			this.settings.window_height = $(window).height();
			this.settings.window_scrolltop = $(window).scrollTop();
			if(this.settings.window_scrolltop > this.settings.sidebar_offset) {
				if(this.settings.sidebar_height > this.settings.window_height) {
					this.settings.sidebar_margin = this.settings.sidebar_margin_default;
				} else {
					this.settings.sidebar_margin = this.settings.window_scrolltop - this.settings.sidebar_offset + this.settings.sidebar_margin_default + this.settings.sidebar_padding;
					if((this.settings.sidebar_height + this.settings.sidebar_margin) > this.settings.body_col_height) {
						this.settings.sidebar_margin = this.settings.body_col_height - this.settings.sidebar_height;
					}
				}
			} else {
				this.settings.sidebar_margin = this.settings.sidebar_margin_default;
			}
			this.settings.sidebar.stop().animate({ marginTop: this.settings.sidebar_margin }, 250);
		}
	};
	singleProject.init();




	/*
	// TODO - NEEDS WORK.  NEEDS TO BE INTEGRATED WITH MY STYLE OF WRITING
	$(function() {

		var $sidebar   = $('.pg-design-single .col-sidebar'),
			$window    = $(window),
			offset     = $sidebar.offset(),
			topPadding = 15;

		$window.scroll(function() {
			if ($window.scrollTop() > offset.top) {
				$sidebar.stop().animate({
					marginTop: $window.scrollTop() - offset.top + topPadding
				});
			} else {
				$sidebar.stop().animate({
					marginTop: 0
				});
			}
		});

	});
*/



	/*
	// ===== GLOBAL ELEMENTS / FEATURES
	// ================================================================================

	var globalFeatures = {
		settings: {
			btn_to_top: $('.return-to-top')
		},
		init: function() {
			this.bindUIActions();
		},
		bindUIActions: function() {
			// Return to Top Button
			this.settings.btn_to_top.on('click', function() {
				globalFeatures.returnToTop();
			});
		},

		// Return the user to the top of the page
		returnToTop: function() {
			$('html, body').animate({
				scrollTop: 0
			}, 300);
		}
	};
	globalFeatures.init();



	// ===== HEADER - SEARCH FORM
	// ================================================================================

	var headerSearchForm = {
		settings: {
			form: $('.page-header .search-form'),
			input: $('.page-header .search-form .search-query'),
			placeholder: 'Search'
		},
		init: function() {
			// Set initial placeholder value
			this.settings.input.val(this.settings.placeholder);
			this.bindUIActions();
		},
		bindUIActions: function() {
			this.settings.input.on('focus blur', function(e) {
				headerSearchForm.manageState(e.type, $(this).val());
			});
			this.settings.form.on('submit', function(e) {
				return headerSearchForm.manageState(e.type, headerSearchForm.settings.input.val());
			});
		},
		manageState: function(e, val) {
			// Manage placeholder text on focus
			if((e==='focus') && (val===this.settings.placeholder)) {
				this.settings.input.val('');
			}
			// Manage placeholder text on blur
			if((e==='blur') && (val==='')) {
				this.settings.input.val(this.settings.placeholder);
			}
			// Prevent form submission if necessary
			if((e==='submit') && ((val===this.settings.placeholder) || val==='')) {
				return false;
			}
		}
	};
	headerSearchForm.init();



	// ===== HEADER - USER ACCOUNT MENU
	// ================================================================================

	var headerUserMenu = {
		settings: {
			elem: $('.page-header .user-menu')
		},
		init: function() {
			this.bindUIActions();
		},
		bindUIActions: function() {
			this.settings.elem.on('touchstart mouseenter mouseleave', function(e) {
				e.preventDefault();
				headerUserMenu.manageState(e.type);
			});
		},
		manageState: function(e) {
			// Toggle the menu on touch events
			if(e==='touchstart') {
				this.settings.elem.toggleClass('active');
			}
			// Show the menu on mouseenter
			if(e==='mouseenter') {
				this.settings.elem.addClass('active');
			}
			// Hide the menu on mouseleave
			if(e==='mouseleave') {
				this.settings.elem.removeClass('active');
			}
		}
	};
	headerUserMenu.init();



	// ===== HEADER - MAIN NAVIGATION
	// ================================================================================

	var headerNav = {
		settings: {
			nav: $('.page-header-nav'),
			nav_ul: $('.page-header-nav > ul'),
			nav_trigger: $('.main-nav-trigger'),
			subnav_trigger: $('.page-header-nav .subnav-trigger'),
			sf: { // Superfish
				instance: {},
				options: {
					delay: 100,
					speed: 200,
					speedOut: 0,
					cssArrows: false,
				}
			}
		},
		init: function() {
			this.sfInit();
			this.bindUIActions();
		},
		bindUIActions: function() {
			this.settings.nav_trigger.on('touchstart click', function(e) {
				e.preventDefault(); // prevent double-firing on touch
				headerNav.toggleMobileMenu();
			});
			this.settings.subnav_trigger.on('touchstart click', function(e) {
				e.preventDefault(); // prevent double-firing on touch
				var subnav = $(this).parent('a').parent('li');
				headerNav.toggleSubNav(subnav);
				return false;
			});
		},

		// Expand/Collapse the main navigation menu for mobile users
		toggleMobileMenu: function() {
			this.settings.nav.toggleClass('active');
			// Collapse all submenus when the main menu is closed
			if(!this.settings.nav.hasClass('active')) {
				this.settings.nav.find('li').removeClass('active');
			}
		},

		// Expand/Collapse any subnav menu for mobile users
		toggleSubNav: function(subnav) {
			subnav.toggleClass('active');
			// Collapse any children if the parent is collapsed
			if(!subnav.hasClass('active')) {
				subnav.find('li').removeClass('active');
			}
		},

		// Initialize Superfish functionality on the main navigation menu
		sfInit: function() {
			this.settings.sf.instance = $(this.settings.nav_ul).superfish(this.settings.sf.options);
		},

		// Restore Superfish functionality on the main navigation menu
		sfRestore: function() {
			this.settings.sf.instance.superfish(this.settings.sf.options);
			// Reset the state of the mobile menu, in the event that submenus were open.
			this.settings.nav.removeClass('active');
			this.settings.nav.find('li').removeClass('active');
		},

		// Destroy Superfish functionality on the main navigation menu
		sfDestroy: function() {
			this.settings.sf.instance.superfish('destroy');
		}
	};
	headerNav.init();



	// ===== HEADER - GENERIC PAGE TITLE
	// ================================================================================

	var headerPageTitle = {
		settings: {
			title_header: $('.page-header-title'),
			title_body: $('.page-body-title'),
			title_body_soft: $('.page-body h1:first')
		},
		init: function() {
			if(this.settings.title_header.text() === '') {
				this.setPageTitle();
			}
		},

		// Extract the title from the body and place it in the header
		setPageTitle: function() {
			var title = this.settings.title_body.text();
			if(title === '') {
				title = this.settings.title_body_soft.text();
			}
			this.settings.title_header.text(title);
		}
	}
	headerPageTitle.init();



	// ===== HOME PAGE
	// ================================================================================

	var pageHome = {
		settings: {
			required_element: $('.page-home'),
			slider: $('.page-header-slider'),
			slider_ctrl_next: $('.page-header-slider-next'),
			slider_ctrl_prev: $('.page-header-slider-prev'),
			bx: { // bxSlider
				instance: {},
				options: {
					auto: true,
					autoHover: true,
					controls: false,
					mode: 'fade',
					pause: 8000,
					pagerSelector: $('.page-header-slider-pager'),
				}
			},
			response: { // Response JS
				options: {
					prop: "width",
					prefix: "src",
					breakpoints: [700, 1024, 1346],
					lazy: true
				}
			}
		},
		init: function() {
			if(globalHelper.elementExists(this.settings.required_element)) {
				this.responseInit();
				this.bxInit();
				this.bindUIActions();
			}
		},
		bindUIActions: function() {
			this.settings.slider_ctrl_next.on('touchstart click', function(e) {
				e.preventDefault(); // prevent double-firing on touch
				pageHome.bxStop();
				pageHome.bxNextSlide();
			});
			this.settings.slider_ctrl_prev.on('touchstart click', function(e) {
				e.preventDefault(); // prevent double-firing on touch
				pageHome.bxStop();
				pageHome.bxPrevSlide();
			});
		},

		// Initialize Response JS for responsive content management (e.g. image swapping for art direction)
		responseInit: function() {
			Response.create(this.settings.response.options);
		},

		// Initialize bxSlider functionality for the home page slider
		bxInit: function() {
			this.settings.bx.instance = this.settings.slider.bxSlider(this.settings.bx.options);
		},

		// bxSlider:  stop the auto-play
		bxStop: function() {
			this.settings.bx.instance.stopAuto();
		},

		// bxSlider:  go to the next slide
		bxNextSlide: function() {
			this.settings.bx.instance.goToNextSlide();
		},

		// bxSlider:  go to the previous slide
		bxPrevSlide: function() {
			this.settings.bx.instance.goToPrevSlide();
		}
	};
	pageHome.init();



	// ===== PRODUCT VIEW - PRODUCT IMAGE(S)
	// ================================================================================

	var productViewImg = {
		settings: {
			required_element: $('.product-view-img'),
			cz: { // Cloud Zoom
				options: { }
			}
		},
		init: function() {
			if(globalHelper.elementExists(this.settings.required_element)) {
				CloudZoom.quickStart();
			}
		}
	};
	productViewImg.init();



	// ===== PRODUCT VIEW - ADD TO CART FORM
	// ================================================================================

	var productViewAddtoCart = {
		settings: {
			required_element: $('.product-view-addtocart'),
			atc: $('.product-view-addtocart'),
			step_lvl: $('.atc-header .step-level'),
			step_title: $('.atc-header .step-title'),
			step1_group: $('.atc-color-grid'),
			step2_group: $('.atc-product-grid'),
			btn_goto_step1: $('.atc-add-color-btn'),
			btn_goto_step2: $('.atc-select-size-btn'),
			btn_select_all_colors: $('.atc-select-all-colors'),
			btn_add_to_cart: $('.btn-add-to-cart'),
			qty_input: $('.atc-product-qty'),
			product_data: null,
			timer: 0,
			timer_delay: 1000,
		},
		init: function() {
			if(globalHelper.elementExists(this.settings.required_element)) {
				this.bindUIActions();
			}
			// Product data should have been left behind inside a Javascript variable on product pages
			if(typeof productDataDeadDrop !== 'undefined') {
				this.settings.product_data = productDataDeadDrop;
			}
		},
		bindUIActions: function() {
			this.settings.btn_goto_step2.on('touchstart click', function(e) {
				e.preventDefault(); // prevent double-firing on touch
				productViewAddtoCart.gotoStep2();
			});
			this.settings.btn_goto_step1.on('touchstart click', function(e) {
				e.preventDefault(); // prevent double-firing on touch
				productViewAddtoCart.gotoStep1();
			});
			this.settings.btn_select_all_colors.on('click', function() {
				productViewAddtoCart.selectAllColors();
			});
			this.settings.qty_input.on('change keydown', function(e) {
				productViewAddtoCart.onProductQtyChange(e, $(this));
			});
			this.settings.btn_add_to_cart.on('touchstart click', function(e) {
				e.preventDefault(); // prevent double-firing on touch
				productViewAddtoCart.addToCart();
			});
		},

		// TODO - Still working ...
		addToCart: function() {
			console.log('get in that cart');
		},

		// Aids in providing the user with immediate feedback regarding product quantity input.
		// Product quantity validation executes on a timed delay onKeydown, and immediately onChange.
		onProductQtyChange: function(e, elem) {
			if(e.type == 'keydown') {
				clearTimeout(this.settings.timer);
				this.settings.timer = setTimeout(function() { productViewAddtoCart.validateProductQty(elem); }, this.settings.timer_delay);
			}
			if(e.type == 'change') {
				clearTimeout(this.settings.timer);
				this.validateProductQty(elem);
			}
		},

		// TODO - Still working ...
		validateProductQty: function(elem) {
			console.log('validating product qty ...');
		},

		// Selects all colors in Step 1 of the "Add to Cart" process.
		selectAllColors: function() {
			this.settings.step1_group.find(':checkbox').prop('checked', 'checked');
		},

		// Attempts to transition to Step 1 of the "Add to Cart" process.
		gotoStep1: function() {
			this.toggleSteps('1', this.settings.step2_group, this.settings.step1_group);
		},

		// Attempts to transition to Step 2 of the "Add to Cart" process.
		gotoStep2: function() {
			var _this = this;
			// Make sure at least one color has been selected
			var colors_checked = this.settings.step1_group.find('input:checkbox:checked');
			if(colors_checked.length <= 0) {
				alert('Select at least one color'); // TODO - Replace with "global messaging system"
				return;
			}
			// Activate the selected colors in Step 2
			this.settings.step2_group.find('tbody tr').removeClass('active');
			colors_checked.each(function() {
				var color_id = $(this).data('color');
				_this.settings.step2_group.find('tr.color-row-'+color_id).addClass('active');
			});
			// Reset any quantity value (in Step 2) associated with the unselected colors.
			// This should prevent accidental additions to the cart (should the user change their mind about a color).
			var colors_unchecked = this.settings.step1_group.find('input:checkbox:not(:checked)');
			colors_unchecked.each(function() {
				var color_id = $(this).data('color');
				_this.settings.step2_group.find('tr.color-row-'+color_id+' input').val('');
			});

			// If everything checks out, proceed to Step 2
			this.toggleSteps('2', this.settings.step1_group, this.settings.step2_group);
		},

		// Toggles the display of the desired step.
		toggleSteps: function(active_step_num, step_to_close, step_to_open) {
			var _this = this;
			// Update the step level/title
			this.settings.step_lvl.html(this.settings.step_lvl.data('step'+active_step_num));
			this.settings.step_title.html(this.settings.step_title.data('step'+active_step_num));
			// Display the appropriate step group
			step_to_close.slideUp(500);
			step_to_open.slideDown(500, function() {
				// Make sure the top of the form remains in the viewport.
				var vals = {
					atcTop: _this.settings.atc.offset().top,
					winTop: $(window).scrollTop(),
					winHeight: $(window).height(),
				};
				if(!((vals.winTop <= vals.atcTop) && (vals.atcTop < (vals.winTop + vals.winHeight)))) {
					$('html,body').animate({ scrollTop: vals.atcTop }, 500);
				}
			});
		},
	};
	productViewAddtoCart.init();



	// ===== PRODUCT VIEW - SECONDARY DATA - TABBED CONTENT
	// ================================================================================

	var productViewExtra = {
		settings: {
			required_element: $('.product-view-extra'),
			link: $('.link-product-view-extra'),
			base: $('.product-view-extra'),
			tab: $('.product-view-extra .tab'),
		},
		init: function() {
			if(globalHelper.elementExists(this.settings.required_element)) {
				this.setInitialState();
				this.bindUIActions();
			}
		},
		bindUIActions: function() {
			this.settings.link.on('click', function() {
				productViewExtra.scrollToExtraProductInfo();
			});
			this.settings.tab.on('touchstart click', function(e) {
				e.preventDefault(); // prevent double-firing on touch
				if(!$(this).hasClass('active')) {
					productViewExtra.toggleTabContent($(this).data('tab'));
				}
			});
		},

		// Scroll the browser to the Extra Product Info area
		scrollToExtraProductInfo: function() {
			$('html,body').animate({ scrollTop: this.settings.base.offset().top }, 500);
		},

		// Set the initial state of the tabbed content
		setInitialState: function() {
			this.settings.base.find('.tabs .tab:first').addClass('active');
			this.settings.base.find('.tab-pod:first .tab').addClass('active');
			this.settings.base.find('.tab-pod:first .content').show();
		},

		// Toggle the display of the appropriate tabbed content
		toggleTabContent: function(t_index) {
			this.settings.base.find('.content').hide();
			this.settings.tab.removeClass('active');
			this.settings.base.find('.tab'+t_index).addClass('active');
			this.settings.base.find('.pod'+t_index+' .content').show();
			// TODO - Scroll to top of active tab if out of view (above/below window bounds)
		}
	};
	productViewExtra.init();
	*/



});