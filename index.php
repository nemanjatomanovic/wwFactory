<?php
session_start();
if(!isset($_SESSION['idKorisnik'])){
    header("Location: login.php");
}else {
  $sesijaId = $_SESSION['idKorisnik'];
}
 ?>

  <!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Notes</title>
    <link rel="shortcut icon" href="note.png" type="image/x-icon">
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    <script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.css">
    <link rel="stylesheet" href="notes.css">

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.16/af-2.2.2/b-1.5.1/b-colvis-1.5.1/b-flash-1.5.1/b-html5-1.5.1/b-print-1.5.1/cr-1.4.1/fc-3.2.4/fh-3.1.3/kt-2.3.2/r-2.2.1/rg-1.0.2/rr-1.2.3/sc-1.4.4/sl-1.2.5/datatables.min.css"/>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.16/af-2.2.2/b-1.5.1/b-colvis-1.5.1/b-flash-1.5.1/b-html5-1.5.1/b-print-1.5.1/cr-1.4.1/fc-3.2.4/fh-3.1.3/kt-2.3.2/r-2.2.1/rg-1.0.2/rr-1.2.3/sc-1.4.4/sl-1.2.5/datatables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.js"></script>


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap4.min.css">

    <link rel="shortcut icon" type="image/png" href="logo.png"/>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.19.1/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/plug-ins/1.10.16/sorting/datetime-moment.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.19.1/locale/af.js"></script>

    <!-- kraj za DataTable -->
  </head>
  <body>

<div class="sidenav">
  <a href="#" id='dodajBelesku'><i class="fas fa-plus-circle"></i> Nova beleška</a>
  <a href="#" id='logout'><i class="fas fa-sign-out-alt"></i> Log out</a>
</div>
<div class="container-fluid" id='main'>
  <div class="row">
<div class="col-md-10">
  <table id="noteTable" class="table table-striped table-bordered" cellspacing="0"></table>
</div>
  </div>
</div>

  </body>


  <script type="text/javascript">
  var tabelaNotes, porukaVar,datumVar,nazivVar,idVar;
  loadData().done(function(data) {
    tabelaNotes = $('#noteTable').DataTable({
      data: data.data,
      responsive:true,
      fixedHeader:true,
      processing: true,
      pageLength: 10,
      select:{
        style:"single",
        info: false
      },
      language:{
        paginate:{
          first:"Prva",
          last:"Poslednja",
          next:"Sledeća",
          previous:"Prethodna"
        },
        emptyTable: "Nema podataka u tabeli",
        lengthMenu: "Prikaz _MENU_ unosa",
        search:     "Pretraga:",
        info:       "Prikazujem _START_ do _END_ od _TOTAL_ unosa",
        processing:  "Obrada..."
      },
        order: [[ 0, "desc" ]],
    columns:[
      {data:'id',orderable:true,title:'id',visible:false},
      {data:'username',orderable:true,title:'Korisnik'},
      {data:'naziv',orderable:true,title:'Naziv'},
      {data:'napomena',orderable:true,title:'Poruka',visible:false},
      {data:'datum',orderable:true,title:'Datum'}
    ]
    });
  });

    $(function() {
      $('[data-toggle="tooltip"]').tooltip()

      tabelaNotes.on('select', function(e, dt, type, indexes) {
          porukaVar = tabelaNotes.rows(indexes).data()[0].napomena;
          idvar = tabelaNotes.rows(indexes).data()[0].id;
          nazivVar = tabelaNotes.rows(indexes).data()[0].naziv;
          datumVar = tabelaNotes.rows(indexes).data()[0].datum
          $.alert({
            title:'Detalji',
            content:"<form><div class=form-group'>  <input type='text' class='form-control' id='nazivIzmena' data-toggle='tooltip' data-placement='auto' title='Tooltip on top' value='"+nazivVar+"' required>  </div>  <div class='form-group'> <textarea class='form-control' id='porukaIzmena' rows='3' required>"+porukaVar+"</textarea> </div>  <div class='form-group'> <input type='text' class='form-control' id='datum' value='"+datumVar+"' disabled> </div>  </form>",
            columnClass: 'medium',
            animationSpeed: 650,
            icon: 'fas fa-info-circle',
            animation: 'zoom',
            closeAnimation: 'scale',
            type:'blue',
            theme:'modern',
            buttons:{
              sacuvaj:{
                text:'Sačuvaj izmene',
                btnClass: 'btn-success',
                action:function() {
                  updateData(idvar,$('#porukaIzmena').val(),$('#nazivIzmena').val())
                  .done(function() {
                      $.alert({
                        title:'Uspešnо!',
                        icon:'fa fa-check',
                        content:'Uspešno ste izmenili sledeću belešku :'+' </br>'+nazivVar+'.',
                        type:'green',
                        theme:'supervan',
                        buttons:{
                          ok:{
                            text:'OK!',
                            btnClass:'btn-primary',
                            action:function() {
                              location.reload();
                            }
                          }
                        }
                      })
                    }).fail(function() {
                      $.alert({
                        title:'Neuspešnо!',
                        icon:'fa fa-warning',
                        content:'Beleška nije izmenjena!',
                        type:'red',
                        animation: 'zoom',
                        closeAnimation: 'scale',
                        theme:'supervan',
                        buttons:{
                          ok:{
                            text:'OK!',
                            btnClass:'btn-danger',
                            action:function() {
                              location.reload();
                            }
                          }
                        }
                      })
                    })
                }
              },
              nazad:{
                text:'Nazad',
                btnClass: 'btn-info',
              },
              izbrisi:{
                text:'Obriši',
                btnClass:'btn-danger',
                action: function() {
                  removeData(idvar)
                  .done(function() {
                      $.alert({
                        title:'Uspešnо!',
                        icon:'fa fa-check',
                        content:'Uspešno ste obrisali sledeću belešku :'+' </br>'+nazivVar+'.',
                        type:'green',
                        theme:'supervan',
                        buttons:{
                          ok:{
                            text:'OK!',
                            btnClass:'btn-primary',
                            action:function() {
                              location.reload();
                            }
                          }
                        }
                      })
                    }).fail(function() {
                      $.alert({
                        title:'Neuspešnо!',
                        icon:'fa fa-warning',
                        content:'Beleška nije obrisana!',
                        type:'red',
                        animation: 'zoom',
                        closeAnimation: 'scale',
                        theme:'supervan',
                        buttons:{
                          ok:{
                            text:'OK!',
                            btnClass:'btn-danger',
                            action:function() {
                              location.reload();
                            }
                          }
                        }
                      })
                    })
                }
              }
            }
          })
      });
      $('#dodajBelesku').on('click',function() {
        $.alert({
          title:'Nova beleška',
          content:"<form><div class=form-group'>  <input type='text' class='form-control' id='nazivBeleska' data-toggle='tooltip' data-placement='auto' title='Unesite naziv koji vas asocira na poruku' placeholder='Naziv' required>  </div>  <div class='form-group'> <textarea class='form-control' id='porukaBeleska' rows='3' placeholder='Beleška' data-toggle='tooltip' data-placement='auto' title='Unesite poruku koja će biti sačuvana kao nova beleška' required></textarea> </div></form>",
          columnClass: 'medium',
          animationSpeed: 650,
          icon: 'far fa-sticky-note',
          animation: 'zoom',
          closeAnimation: 'scale',
          type:'green',
          theme:'modern',
          buttons:{
            sacuvaj:{
              text:'Sačuvaj belešku',
              btnClass: 'btn-success',
              action: function() {
              addData($('#porukaBeleska').val(),$('#nazivBeleska').val())
              .done(function() {
                  $.alert({
                    title:'Uspešnо!',
                    icon:'fa fa-check',
                    content:'Uspešno ste dodali novu belešku.',
                    type:'green',
                    theme:'supervan',
                    buttons:{
                      ok:{
                        text:'OK!',
                        btnClass:'btn-primary',
                        action:function() {
                          location.reload();
                        }
                      }
                    }
                  })
                }).fail(function() {
                  $.alert({
                    title:'Neuspešnо!',
                    icon:'fa fa-warning',
                    content:'Beleška nije dodata!',
                    type:'red',
                    animation: 'zoom',
                    closeAnimation: 'scale',
                    theme:'supervan',
                    buttons:{
                      ok:{
                        text:'OK!',
                        btnClass:'btn-danger',
                        action:function() {
                          location.reload();
                        }
                      }
                    }
                  })
                })
              }
            },
            nazad:{
              text:'Nazad',
              btnClass: 'btn-info',
            },
          }
        })
      });
      $('#logout').on('click',function() {
        logout();
      })
    });
        function loadData () {
          return $.ajax({
            url:'php/getUserNotes.php',
            type: 'POST',
            data: { 'user': '<?php echo $sesijaId;?>'},
            dataType: 'JSON'
          });
        }
        function addData (porukaBeleska,nazivBeleska) {
        return $.ajax({
            type:'POST',
            url:'php/insertNoteData.php',
            data:{'user':'<?php echo $sesijaId;?>','poruka':porukaBeleska,'naziv':nazivBeleska}
        });
      }

      function removeData (idBeleske) {
        return $.ajax({
          type:'POST',
          url:'php/deleteNote.php',
          data:{'id':idBeleske}
        });
      }

      function updateData (idBeleske,novaPoruka,noviNaziv) {
        return $.ajax({
          type:'POST',
          url:'php/updateNote.php',
          data:{'id':idBeleske, 'poruka':novaPoruka,'naziv':noviNaziv}
        });
      }
      function logout () {
        $.ajax({
          type:'POST',
          url:'php/logout.php',

        }).done(function() {
          window.open('login.php','_self');
        });

      }
  </script>


</html>
