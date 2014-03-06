var TableThing = (function() {

  var defaults = {
    selector: '.table-fix-header',
    table: null,
    currentX: null,
    thead: []
  }

  function TableThing(){
    this.params = {};
  };

  TableThing.prototype.init = function(options)
  {
    this.params = $.extend(defaults, options);

    this.params.table = $(this.params.selector);
  }

  TableThing.prototype.fixThead = function() {

    var self = this;

    // empty our array to begin with
    self.params.thead = [];

    // Current X position
    self.params.currentX = $("thead", self.params.table).offset().left;

    console.log(self.params.currentX);
    console.log(self.params.table.width());

    var tableWidth = self.params.table.width();

    // loop over the first row of td's in &lt;tbody> and get the widths of individual &lt;td>'s
    $('tbody tr:eq(1) td', self.params.table).each( function(i,v){
      self.params.thead.push($(v).width());
    });

    // now loop over our array setting the widths we've got to the &lt;th>'s
    for(i=0;i<self.params.thead.length;i++) {
      $('thead th:eq('+i+')', self.params.table).width(self.params.thead[i]);
    }

    var cloneThead = $($("thead", self.params.table));

    // here we attach to the scroll, adding the class 'fixed' to the &lt;thead>
    $(window).scroll(function() {
      var windowTop = $(window).scrollTop();

      console.log('scroll top', windowTop);
      console.log('table width', self.params.table.width());

      if (windowTop > self.params.table.offset().top) {
        //$("thead", self.params.table).addClass("fixed");

        $("thead", self.params.table).addClass("absolute");


        $("thead", self.params.table).css('top', windowTop - 180);


        console.log('table ', self.params.table.offset().top, ' thead', $("thead", self.params.table).offset().top)



      }
      else {
        $("thead", self.params.table).removeClass("absolute");
      }
    });
  }

  return new TableThing();
})();

