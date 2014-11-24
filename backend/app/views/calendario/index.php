<?php  include("../header.php");?>
<script>
  $(function () {
      var options = {
      events_source: 'events.json.php',
      view: 'month',
      tmpl_path: 'tmpls/',
      tmpl_cache: false,
      day: toMysqlFormat1(new Date()),
      onAfterEventsLoad: function(events) {
        if(!events) {
          return;
        }
        var list = $('#eventlist');
        list.html('');

        $.each(events, function(key, val) {
          $(document.createElement('li'))
            .html('<a href="' + val.url + '">' + val.title + '</a>')
            .appendTo(list);
        });
      },
      onAfterViewLoad: function(view) {
        $('.page-header h3').text(this.getTitle());
        $('.btn-group button').removeClass('active');
        $('button[data-calendar-view="' + view + '"]').addClass('active');
      },
      classes: {
        months: {
          general: 'label'
        }
      }
    };


    function twoDigits(d) {
      if(0 <= d && d < 10) return "0" + d.toString();
      if(-10 < d && d < 0) return "-0" + (-1*d).toString();
      return d.toString();
    }
    function toMysqlFormat1(date) {
        return date.getFullYear() + "-" + twoDigits(1 + date.getMonth()) + "-" + twoDigits(date.getDate());
    }

    var calendar = $('#calendar').calendar(options);

  $('.btn-group button[data-calendar-nav]').each(function() {
    var $this = $(this);
    $this.click(function() {
      calendar.navigate($this.data('calendar-nav'));
    });
  });

  $('.btn-group button[data-calendar-view]').each(function() {
    var $this = $(this);
    $this.click(function() {
      calendar.view($this.data('calendar-view'));
    });
  });

  $('#first_day').change(function(){
    var value = $(this).val();
    value = value.length ? parseInt(value) : null;
    calendar.setOptions({first_day: value});
    calendar.view();
  });

  $('#language').change(function(){
    calendar.setLanguage($(this).val());
    calendar.view();
  });

  $('#events-in-modal').change(function(){
    var val = $(this).is(':checked') ? $(this).val() : null;
    calendar.setOptions({modal: val});
  });
  $('#events-modal .modal-header, #events-modal .modal-footer').click(function(e){
    //e.preventDefault();
    //e.stopPropagation();
  });
  });
</script>
        <h1>Citas</h1>
          <div class="page-header">
            <div class="form-inline">
                <div class="btn-group pull-left" style="margin-top:-30px">
                  <button class="btn btn-primary" data-calendar-nav="prev"><< Prev</button>
                  <button class="btn btn-default" data-calendar-nav="today">Today</button>
                  <button class="btn btn-primary" data-calendar-nav="next">Next >></button>
                </div>
                <div class="btn-group pull-right" style="margin-top:-30px">
                  <button class="btn btn-warning" data-calendar-view="year">Year</button>
                  <button class="btn btn-warning active" data-calendar-view="month">Month</button>
                  <button class="btn btn-warning" data-calendar-view="week">Week</button>
                  <button class="btn btn-warning" data-calendar-view="day">Day</button>
                </div>
            </div>
        </div>
        <div>
</div>


  <div class="row">
  <div class="col-md-12">
    <div id="calendar"></div>
<?php  include("../footer.php"); ?>