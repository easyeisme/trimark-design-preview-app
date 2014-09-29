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

		// Scrolls the browser viewport to a designated target
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
			sidebar: $('.col-sidebar'),
			sidebar_offset: 0, // Sidebar initial/natural position (relative to the top of the window)
			sidebar_height: 0,
			sidebar_margin: 0, // Sidebar top margin (manipulated to make sidebar stay with scroll)
			sidebar_margin_default: 0, // Initial sidebar top margin (used to reset to default state)
			sidebar_padding: 15, // Allows for additional spacing away from the browser window (optional)
			body_col: $('.col-body'),
			body_col_height: 0,
			window_height: 0,
			window_scrolltop: 0
		},
		init: function() {
			if(globalHelper.elementExists(this.settings.required_element)) {
				this.bindUIActions();
				// Collect information about the default state of the sidebar, body column, and browser window
				this.settings.sidebar_offset = this.settings.sidebar.offset().top;
				this.settings.sidebar_margin_default = parseInt(this.settings.sidebar.css('marginTop'));
				this.settings.sidebar_height = this.settings.sidebar.height();
				this.settings.body_col_height = this.settings.body_col.height();
				this.settings.window_height = $(window).height();
			}
		},
		bindUIActions: function() {
			$(window).scroll(function() {
				clearTimeout(singleProject.scroll_timer);
				singleProject.scroll_timer = setTimeout(function() { singleProject.positionSidebar(); }, 250);
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
			this.settings.window_scrolltop = $(window).scrollTop();
			// If the top of the browser window has surpassed the top of the sidebar ...
			if(this.settings.window_scrolltop > this.settings.sidebar_offset) {
				// Reposition the sidebar only if it's shorter than the height of the browser window
				if(this.settings.sidebar_height > this.settings.window_height) {
					this.settings.sidebar_margin = this.settings.sidebar_margin_default;
				} else {
					// Determine the new sidebar position
					this.settings.sidebar_margin = this.settings.window_scrolltop - this.settings.sidebar_offset + this.settings.sidebar_margin_default + this.settings.sidebar_padding;
					// Do not allow the sidebar to exceed the length of the body column associated with it
					if((this.settings.sidebar_height + this.settings.sidebar_margin) > this.settings.body_col_height) {
						this.settings.sidebar_margin = this.settings.body_col_height - this.settings.sidebar_height;
					}
				}
			} else {
				this.settings.sidebar_margin = this.settings.sidebar_margin_default;
			}
			// Finally, position the sidebar based on the settings collected above
			this.settings.sidebar.stop().animate({ marginTop: this.settings.sidebar_margin }, 250);
		}
	};
	singleProject.init();



	// ===== DESIGN COMP
	// ================================================================================

	// TODO - comp meta is not displaying when bxSlider is activated.  It may be worthwile
	// to just come up with another solution.  What I have feels bloated.
	var designComp = {
		settings: {
			required_element: $('.pg-design-attachment'),
			header: $('.header-main'),
			project_comp_grid_trigger: $('.header-btn-comp-grid'),
			project_comp_grid: $('.header-project-comp-grid'),
			project_comp: $('.header-project-comp-grid li'),
			project_comp_first: $('.header-project-comp-grid li').eq(0),
			project_comp_meta: $('.header-project-comp-grid .comp-meta'),
			project_comp_grid_pos0: 0, // hidden
			project_comp_grid_pos1: 0, // displayed
			wrapper_width: $('.header-main .page-wrapper.main').width(),
			comp_width: 0,
			comp_count: 0,
			bx: { // bxSlider
				instance: {},
				slider: $('.header-project-comp-grid ul'),
				ctrl: {
					ctrl: $('.header-project-comp-grid-ctrl'),
					prev: $('.header-project-comp-grid-ctrl.ctrl-prev'),
					next: $('.header-project-comp-grid-ctrl.ctrl-next')
				},
				ctrl_width: 0, // calculated before initializing
				options: {
					controls: false,
					infiniteLoop: false,
					minSlides: 0, // calculated before initializing
					maxSlides: 0, // calculated before initializing
					pager: false,
					slideWidth: 0, // calculated before initializing
					//pagerSelector: $('.page-header-slider-pager'),
				}
			}
		},
		init: function() {
			if(globalHelper.elementExists(this.settings.required_element)) {
				this.settings.comp_width = this.settings.project_comp_first.outerWidth();
				this.settings.comp_count = this.settings.project_comp.length;
				this.bindUIActions();
				this.setupDesignCompGrid();
				this.bxInit();
			}
		},
		bindUIActions: function() {
			this.settings.project_comp_grid_trigger.on('click', function() {
				designComp.toggleDesignCompGrid();
			});
			this.settings.bx.ctrl.prev.on('click', function() {
				designComp.bxPrevSlide();
			});
			this.settings.bx.ctrl.next.on('click', function() {
				designComp.bxNextSlide();
			});
		},

		// Set the initial state of the Design Comp Grid
		setupDesignCompGrid: function() {
			// Define hidden/displayed positions of the design comp grid
			this.settings.project_comp_grid_pos0 = -(this.settings.project_comp_grid.outerHeight() - this.settings.header.height());
			this.settings.project_comp_grid_pos1 = this.settings.project_comp_grid_pos0 + this.settings.project_comp_grid.height();

			// Set initial state
			this.settings.project_comp_grid.css({
				top: this.settings.project_comp_grid_pos0
			});

			// Position comp meta information
			this.settings.project_comp_meta.css({
				top: this.settings.project_comp_first.height() + 9
			});
		},

		// Toggle the display of the Design Comp Grid
		toggleDesignCompGrid: function() {
			if(this.settings.project_comp_grid_trigger.hasClass('closed')) {
				this.settings.project_comp_grid_trigger.removeClass('closed');
				this.settings.project_comp_grid.stop().animate(
					{ top: this.settings.project_comp_grid_pos1 },
					300
				);
			} else {
				this.settings.project_comp_grid_trigger.addClass('closed');
				this.settings.project_comp_grid.stop().animate(
					{ top: this.settings.project_comp_grid_pos0 },
					300
				);
			}
		},

		// Initialize bxSlider functionality for the design comp grid.
		// This should only be done if the grid has more comps than it can fit within one row.
		bxInit: function() {
			if((this.settings.comp_width * this.settings.comp_count) > this.settings.wrapper_width) {
				this.settings.bx.ctrl.ctrl.show();
				this.settings.bx.ctrl_width = this.settings.bx.ctrl.prev.width();
				this.settings.bx.options.slideWidth = this.settings.comp_width;
				this.settings.bx.options.minSlides = Math.floor((this.settings.wrapper_width - (this.settings.bx.ctrl_width * 2)) / this.settings.comp_width);
				this.settings.bx.options.maxSlides = this.settings.bx.options.minSlides ;
				this.settings.bx.instance = this.settings.bx.slider.bxSlider(this.settings.bx.options);
			}
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
	designComp.init();



	// ===== WINDOW ONLOAD
	// ================================================================================

	$(window).load(function() {

		// Modify each design comp link on single project pages so that each link has the same height.
		if(globalHelper.elementExists(singleProject.settings.required_element)) {
			singleProject.matchLinkHeights();
		}

	});

});