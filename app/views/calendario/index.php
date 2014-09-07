<?php  include("../header.php");?>
<script>
angular.module('calendarDemoApp', ['ui.calendar', 'ui.bootstrap']);

function CalendarCtrl($scope) {
    var date = new Date();
    var d = date.getDate();
    var m = date.getMonth();
    var y = date.getFullYear();
    
    $scope.changeTo = 'Hungarian';
    /* event source that pulls from google.com */
    $scope.eventSource = {
            url: "http://www.google.com/calendar/feeds/usa__en%40holiday.calendar.google.com/public/basic",
            className: 'gcal-event',           // an option!
            currentTimezone: 'America/Chicago' // an option!
    };
    /* event source that contains custom events on the scope */
    $scope.events = [
      {title: 'All Day Event',start: new Date(y, m, 1)},
      {title: 'Long Event',start: new Date(y, m, d - 5),end: new Date(y, m, d - 2)},
      {id: 999,title: 'Repeating Event',start: new Date(y, m, d - 3, 16, 0),allDay: false},
      {id: 999,title: 'Repeating Event',start: new Date(y, m, d + 4, 16, 0),allDay: false},
      {title: 'Birthday Party',start: new Date(y, m, d + 1, 19, 0),end: new Date(y, m, d + 1, 22, 30),allDay: false},
      {title: 'Click for Google',start: new Date(y, m, 28),end: new Date(y, m, 29),url: 'http://google.com/'}
    ];
    /* event source that calls a function on every view switch */
    $scope.eventsF = function (start, end, callback) {
      var s = new Date(start).getTime() / 1000;
      var e = new Date(end).getTime() / 1000;
      var m = new Date(start).getMonth();
      var events = [{title: 'Feed Me ' + m,start: s + (50000),end: s + (100000),allDay: false, className: ['customFeed']}];
      callback(events);
    };

    $scope.calEventsExt = {
       color: '#f00',
       textColor: 'yellow',
       events: [ 
          {type:'party',title: 'Lunch',start: new Date(y, m, d, 12, 0),end: new Date(y, m, d, 14, 0),allDay: false},
          {type:'party',title: 'Lunch 2',start: new Date(y, m, d, 12, 0),end: new Date(y, m, d, 14, 0),allDay: false},
          {type:'party',title: 'Click for Google',start: new Date(y, m, 28),end: new Date(y, m, 29),url: 'http://google.com/'}
        ]
    };
    /* alert on eventClick */
    $scope.alertOnEventClick = function( event, allDay, jsEvent, view ){
        $scope.alertMessage = (event.title + ' was clicked ');
    };
    /* alert on Drop */
     $scope.alertOnDrop = function(event, dayDelta, minuteDelta, allDay, revertFunc, jsEvent, ui, view){
       $scope.alertMessage = ('Event Droped to make dayDelta ' + dayDelta);
    };
    /* alert on Resize */
    $scope.alertOnResize = function(event, dayDelta, minuteDelta, revertFunc, jsEvent, ui, view ){
       $scope.alertMessage = ('Event Resized to make dayDelta ' + minuteDelta);
    };
    /* add and removes an event source of choice */
    $scope.addRemoveEventSource = function(sources,source) {
      var canAdd = 0;
      angular.forEach(sources,function(value, key){
        if(sources[key] === source){
          sources.splice(key,1);
          canAdd = 1;
        }
      });
      if(canAdd === 0){
        sources.push(source);
      }
    };
    /* add custom event*/
    $scope.addEvent = function() {
      $scope.events.push({
        title: 'Open Sesame',
        start: new Date(y, m, 28),
        end: new Date(y, m, 29),
        className: ['openSesame']
      });
    };
    /* remove event */
    $scope.remove = function(index) {
      $scope.events.splice(index,1);
    };
    /* Change View */
    $scope.changeView = function(view,calendar) {
      calendar.fullCalendar('changeView',view);
    };
    /* Change View */
    $scope.renderCalender = function(calendar) {
      console.log(calendar);
      calendar.fullCalendar('render');
    };
    /* config object */
    $scope.uiConfig = {
      calendar:{
        height: 450,
        editable: true,
        header:{
          left: 'title',
          center: '',
          right: 'today prev,next'
        },
        eventClick: $scope.alertOnEventClick,
        eventDrop: $scope.alertOnDrop,
        eventResize: $scope.alertOnResize
      }
    };

    $scope.changeLang = function() {
      if($scope.changeTo === 'Hungarian'){
        $scope.uiConfig.calendar.dayNames = ["Vasárnap", "Hétfő", "Kedd", "Szerda", "Csütörtök", "Péntek", "Szombat"];
        $scope.uiConfig.calendar.dayNamesShort = ["Vas", "Hét", "Kedd", "Sze", "Csüt", "Pén", "Szo"];
        $scope.changeTo= 'English';
      } else {
        $scope.uiConfig.calendar.dayNames = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
        $scope.uiConfig.calendar.dayNamesShort = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];
        $scope.changeTo = 'Hungarian';
      }
    };
    /* event sources array*/
    $scope.eventSources = [$scope.events, $scope.eventSource, $scope.eventsF];
    $scope.eventSources2 = [$scope.calEventsExt, $scope.eventsF, $scope.events];
}

</script>
    <div ng-app="calendarDemoApp">
        <section id="directives-calendar" ng-controller="CalendarCtrl">
            
            <div class="row">
              <div class="">
                <div class="col-md-3">
                  
                    <div class="btn-group calTools">
                      <button class="btn" ng-click="changeLang()">
                        {{changeTo}}
                      </button>              
                      <button class="btn" ng-click="addRemoveEventSource(eventSources,eventSource)">
                        Toggle Source
                      </button>
                      <button type="button" class="btn btn-primary" ng-click="addEvent()">
                        Add Event
                      </button>
                    </div>

                    <ul class="unstyled">
                        <li ng-repeat="e in events">
                            <div class="alert alert-info">
                                <a class="close" ng-click="remove($index)"><i class="icon-remove"></i></a>
                                <b> <input ng-model="e.title"></b> 
                                {{e.start | date:"MMM dd"}} - {{e.end | date:"MMM dd"}}
                            </div>
                        </li>
                    </ul>
                </div>

                <div class="col-md-9">
                    <tabset>
                        <tab select="renderCalender(myCalendar1);">
                          <tab-heading>
                           <i class="glyphicon glyphicon-bell"></i> Calendar One
                          </tab-heading>
                          <div class="alert-success calAlert" ng-show="alertMessage != undefined && alertMessage != ''">
                            <h4>{{alertMessage}}</h4>
                          </div>
                          <div class="btn-toolbar">
                            <p class="pull-right lead">Calendar One View Options</p>
                            <div class="btn-group">
                                <button class="btn btn-success" ng-click="changeView('agendaDay', myCalendar1)">AgendaDay</button>
                                <button class="btn btn-success" ng-click="changeView('agendaWeek', myCalendar1)">AgendaWeek</button>
                                <button class="btn btn-success" ng-click="changeView('month', myCalendar1)">Month</button>
                            </div>
                          </div>                   
                        <div class="calendar" ng-model="eventSources" calendar="myCalendar1" config="uiConfig.calendar" ui-calendar="uiConfig.calendar"></div>
                       </tab>
                       <tab select="renderCalender(myCalendar2);">
                        <tab-heading>
                          <i class="glyphicon glyphicon-bell"></i> Calendar Two
                        </tab-heading>
                          <div class="alert-success calAlert" ng-show="alertMessage != undefined && alertMessage != ''">
                            <h4>{{alertMessage}}</h4>
                          </div>
                          <div class="btn-toolbar">
                            <p class="pull-right lead">Calendar Two View Options</p>
                            <div class="btn-group">
                                <button class="btn btn-success" ng-click="changeView('agendaDay', myCalendar2)">AgendaDay</button>
                                <button class="btn btn-success" ng-click="changeView('agendaWeek', myCalendar2)">AgendaWeek</button>
                                <button class="btn btn-success" ng-click="changeView('month', myCalendar2)">Month</button>
                            </div>
                          </div>
                        <div class="calendar" ng-model="eventSources" calendar="myCalendar2" config="uiConfig.calendar" ui-calendar="uiConfig.calendar"></div>
                       </tab>
                       <tab select="renderCalender(myCalendar3);">
                        <tab-heading>
                          <i class="glyphicon glyphicon-bell"></i> Calendar Three
                        </tab-heading>
                          <div class="alert-success calAlert">
                            <h4>This calendar uses the extended form</h4>
                          </div>
                          <div class="btn-toolbar">
                            <p class="pull-right lead">Calendar Three View Options</p>
                            <div class="btn-group">
                                <button class="btn btn-success" ng-click="changeView('agendaDay', myCalendar3)">AgendaDay</button>
                                <button class="btn btn-success" ng-click="changeView('agendaWeek', myCalendar3)">AgendaWeek</button>
                                <button class="btn btn-success" ng-click="changeView('month', myCalendar3)">Month</button>
                            </div>
                          </div>
                        <div class="calendar" ng-model="eventSources2" calendar="myCalendar3" config="uiConfig.calendar" ui-calendar="uiConfig.calendar"></div>
                       </tab>
                    </tabset>
                </div>
            </div>
            </div>
          
        </section>
    </div>


<?php  include("../footer.php"); ?>