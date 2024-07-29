
   </div>
  </div><br>
  <script src="../js/bootstrap.bundle.min.js"></script>
  <script>
  $(document).ready(function(){
      $("#tabla_id").DataTable({
          "pageLength":10,
          lengthMenu:[
              [3,10,20,30,50],
              [3,10,20,30,50]
          ],
          "language":{
             "url":"https://cdn.datatables.net/plug-ins/1.13.1/i18n/es-ES.json"
          }
        })
  });
  </script> 
   </body>
</html> 