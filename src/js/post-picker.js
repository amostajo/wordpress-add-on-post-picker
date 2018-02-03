/**
 * Post Picker javascript file.
 * jQuery Plugin
 *
 * @author Alejandro Mostajo
 * @license MIT
 * @version 2.0.0
 */
(function($) {

	/**
	 * Vue post picker.
	 * Handles browsing and display.
	 * @since 1.0
	 */
	var vuePostPicker = new Vue({

		el: '#post-picker-addon',

		data: {
			/**
			 * Caller ID.
			 * @since 1.0
			 * @var int
			 */
			callerID: 0,
			/**
			 * Flag that indicates if picker is opened or not.
			 * @since 1.0
			 * @var bool
			 */
			opened: false,
			/**
			 * Flag that indicates if picker is loading.
			 * @since 1.0
			 * @var bool
			 */
			isLoading: false,
			/**
			 * Flag that indicates if user can pick multiple items.
			 * @since 1.0
			 * @var bool
			 */
			allowMultiple: true,
			/**
			 * Filter variables.
			 * @since 1.0
			 * @var object
			 */
			filter: {},
			/**
			 * Selected items.
			 * @since 1.0
			 * @var object
			 */
			selected: []
			/**
			 * Post type to filter.
			 * @since 2.0.0
			 * @var string
			 */
			type: undefined,
		},

		computed: {
			/**
			 * Returns flag indicating if there are results.
			 * @since 1.0
			 * @var bool
			 */
			hasData: function () {
				return Object.keys(this.results).length > 0;
			}
		},

		methods: {
			/**
			 * Browse WORDPRESS posts.
			 * @since 1.0
			 */
			browse: function() {
				this.isLoading = true;
				this.$http.get(this.generateUrl(), function (data) {
					this.$set('results', this.merge(data));
					this.isLoading = false;
				});
			},
			/**
			 * Triggers event and closes modal.
			 * @since 1.0
			 */
			onAddSelection: function() {
				$.event.trigger('postselected', [this.selected, this.callerID]);
				this.onClose();
			},
			/**
			 * On submit event.
			 * @since 1.0
			 * @param event e Event.
			 */
			onSubmit: function(e) {
				e.preventDefault();
				this.browse();
			},
			/**
			 * Closes modal.
			 * @since 1.0
			 * @param event e Event.
			 */
			onClose: function(e) {
				if (e != undefined)
					e.preventDefault();
				this.clear();
				this.callerID = 0;
				$(this.$el).css('display', 'none');
			},
			/**
			 * Selects a post.
			 * @since 1.0
			 * @param int index Locator index.
			 */
			onSelect: function(index) {
				this.results[index].selected = !this.results[index].selected;
				if (this.results[index].selected) {
					this.add(this.results[index]);
				} else {
					this.remove(this.results[index]);
				}
			},
			/**
			 * Returns post index by ID.
			 * @since 1.0
			 * @returns object
			 */
			getPostIndex: function(ID) {
				for (var index in this.results) {
					if (this.results[index].ID == ID)
						return index;
				}
				return undefined;
			},
			/**
			 * Adds posts to list of selected.
			 * @since 1.0
			 */
			add: function(post) {
				if (!this.allowMultiple)
					this.clear();
				this.selected.push(post);
			},
			/**
			 * Removes posts to list of selected.
			 * @since 1.0
			 */
			remove: function(post) {
				for (var i = Object.keys(this.selected).length - 1; i >= 0; --i ) {
					if (this.selected[i].ID == post.ID) {
						this.selected.splice(i, 1);
						break;
					}
				}
			},
			/**
			 * Clears selected items.
			 * @since 1.0
			 */
			clear: function() {
				for (var i = Object.keys(this.selected).length - 1; i >= 0; --i ) {
					var index = this.getPostIndex(this.selected[i].ID);
					if (index != undefined)
						this.results[index].selected = false;
					this.remove(this.selected[i]);
				}
			},
			/**
			 * Generates URL based on filter.
			 * @since 1.0
			 * @return string
			 */
			generateUrl: function() {
				// Prepare URL
				var url = $(this.$el).data('url');
				// Check filter
				for (var filter in this.filter) {
					url += '&' + filter + '=' + this.filter[filter];
				}
				return url;
			},
			/**
			 * Merges incoming data with current selected results.
			 * @since 1.0.0
			 * @param array data Browsed data.
			 */
			merge: function(data) {
				var missing = [];
				for (var i in this.selected) {
					var found = false;
					for (var aux in data) {
						if (data[aux].ID == this.selected[i].ID) {
							data[aux].selected = true;
							found = true;
							break;
						}
					}
					if (!found) {
						missing.push(this.selected[i]);
					}
				}
				return $.merge(data, missing);
			}
		},

		ready: function() {
			if (this.type !== undefined)
				this.filter.type = this.type
			this.browse();
		}
	});

	/**
	 * Post Picker plugin function.
	 * @since 1.0
	 */
	$.fn.postPicker = function(options) {
		/**
		 * Element reference
		 * @since 1.0
		 * @var object
		 */
		var self = this;

		/**
		 * Settings.
		 * @since 1.0
		 * @since 2.0.0 Added type (post type as filter).
		 * @var object
		 */
		self.settings = $.extend({
			allowMultiple: true,
			render: true,
			clearTemplate: true,
			clearTarget: true,
			target: undefined,
			success: undefined,
			template: undefined,
			templateElement: undefined,
			type: undefined,
			ID: 0
 		}, options );

		/**
		 * Inits plugin.
		 * @since 1.0
		 * @since 2.0.0 Added type (post type as filter).
		 */
		self.init = function () {
			// Create unique ID
			self.settings.ID = Math.floor(Math.random() * 1000000001);
			// Adds click event
			$(self).click(function(e){
				e.preventDefault();
				vuePostPicker.opened = true;
				vuePostPicker.callerID = self.settings.ID;
				vuePostPicker.type = self.settings.type;
				$(vuePostPicker.$el).css('display', 'block');
			});
			// Allow multiple
			vuePostPicker.allowMultiple = self.settings.allowMultiple;
			// Event
			$(document).on('postselected', self.handler);
			// Template
			if (self.settings.template != undefined) return;
			if (self.settings.templateElement == undefined
				|| $(self.settings.templateElement).length == 0
			) {
				self.settings.template = $(self).html();
				// Hide content
				if (self.settings.clearTemplate)
					$(self).html('');
			} else {
				self.settings.template = $(self.settings.templateElement).html();
				// Hide content
				if (self.settings.clearTemplate)
					$(self.settings.templateElement).html('');
			}
		};

		/**
		 * Handles vue event.
		 * @since 1.0
		 * @param array posts	Posts selected.
		 * @param int   callerID Caller ID.
		 */
		self.handler = function(e, posts, callerID) {
			if (self.settings.ID != callerID) return;
			if (self.settings.render)
				self.render(posts);
			if (self.settings.success != undefined)
				self.settings.success(posts);
		};

		/**
		 * Renderes posts selected.
		 * @since 1.0
		 * @param array posts. 
		 */
		self.render = function(posts) {
			if (self.settings.render
				&& $(self.settings.target) != undefined
			) {
				// Clear ?
				if (self.settings.clearTarget)
					$(self.settings.target).html('');
				// Loop
				$.each(posts, function(index) {
					$(self.settings.target).append(self.parsePost(this));
				});
			}
		};

		/**
		 * Returns parsed post as template.
		 * @since 1.0
		 * @param object post Post.
		 * @return string HTML
		 */
		self.parsePost = function(post) {
			if (post != undefined) {
				var html = self.settings.template;
				// Render properties.
				$.each(post, function(key) {
					html = html.replace(new RegExp('{{' + key + '}}', 'g'), this, html);
					html = html.replace(new RegExp('{{ ' + key + ' }}', 'g'), this, html);
				});
				// Render Image
				html = $(html);
				if (html.find('img').length > 0) {
					html.find('img').attr('src', post.thumb_image_url);
				}
				return html;
			}
			return;
		};

		// init
		self.init();
	};

 })(jQuery);
