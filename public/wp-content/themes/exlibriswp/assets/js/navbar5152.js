// Create menu and submenu standard dropdown
   
   $(function() {
	var Accordion = function(el, multiple) {
		this.el = el || {};
		this.multiple = multiple || false;

		// Variables 
		var links = this.el.find('.dropdown-btn , .dropdown-sidenav-btn');
		// Event
		links.on('click', {el: this.el, multiple: this.multiple}, this.dropdown)
	}

	Accordion.prototype.dropdown = function(e) {
		var $el = e.data.el;
			$this = $(this),
			$next = $this.next();

		$next.slideToggle();
		$this.parent().toggleClass('open');		
	}	

	var accordion = new Accordion($('#accordion , #accordion-sidenav'), false);
});

