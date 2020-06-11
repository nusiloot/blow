

<link href='https://unpkg.com/@fullcalendar/core@4.4.2/main.min.css' rel='stylesheet' />
  <link href='https://unpkg.com/@fullcalendar/timeline@4.4.2/main.min.css' rel='stylesheet' />
  <link href='https://unpkg.com/@fullcalendar/resource-timeline@4.4.2/main.min.css' rel='stylesheet' />
<script src='https://unpkg.com/@fullcalendar/core@4.4.2/main.min.js'></script>
  <script src='https://unpkg.com/@fullcalendar/interaction@4.4.2/main.min.js'></script>
  <script src='https://unpkg.com/@fullcalendar/timeline@4.4.2/main.min.js'></script>
  <script src='https://unpkg.com/@fullcalendar/resource-common@4.4.2/main.min.js'></script>
  <script src='https://unpkg.com/@fullcalendar/resource-timeline@4.4.2/main.min.js'></script>

  <script>

  document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
      plugins: [ 'interaction', 'resourceTimeline' ],
      timeZone: 'UTC',
      header: {
        left: '',
        center: 'title',
        right: 'today,prev,next'
      },
      locale:'fr',
      schedulerLicenseKey: 'GPL-My-Project-Is-Open-Source',
      defaultView: 'resourceTimelineDay',
      scrollTime: '06:00',
      aspectRatio: 1.5,
      editable: true,
      droppable:true,
      selectable:true,
      weekends:false,
      height:'auto',
      resourceLabelText: 'Salles',
      resources:'json-list-resources',
      eventSources:[{url:'json-list-events',textColor: 'black' }],
      select: function(info) {
              //On recupere les input à modifier dans le modal

              var Datedebut = document.getElementById('datededebut');
              var Heuredebut = document.getElementById('heurededebut');
              var Datefin = document.getElementById('datedefin');
              var Heurefin = document.getElementById('heuredefin');
              var nomdesalle = document.getElementById('nomdesalle');
              var salleID = document.getElementById('salleId');
              var capacite = document.getElementById('capacite');
              var surface = document.getElementById('surface');
              nomdesalle.innerHTML = info.resource.title ;
              salleID.value = info.resource.id;

              const dateDebut = (info.startStr).split("T", 2);
              dateDebut[2] = dateDebut[1].split("Z").join("");

              const dateFin = (info.endStr).split("T", 2);
              dateFin[2]= dateFin[1].split("Z").join("");

              Datedebut.value = dateDebut[0] ;
              Heuredebut.value = dateDebut[2] ;
              Datefin.value = dateFin[0] ;
              Heurefin.value = dateFin[2] ;
      },
    });

    calendar.render();
  });

</script>
