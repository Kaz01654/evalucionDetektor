<?php
    include("response.php");
    $newObj = new Data();
    $items = $newObj->getData();
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>  
  <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>            
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
  <title>Evaluacion Practica Detektor</title>
</head>
<body>
  <div class="container">
    <div class="col-sm-12" style="padding-top:50px;">
        <div class="well" style="text-align: center">
            <h2>Evaluacion Practica Detektor</h2>
        </div>
        <div id="msg"></div>
        <div class="table-responsive">  
            <table id="datagrid" class="table table-striped table-bordered" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Motivo</th>
                    <th>Estado</th>
                    <th>Tipo</th>
                    <th>Accion</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($items as $key => $item) :?>
                <tr>
                    <td><?php echo $item['motivo'] ?></td>
                    <td><?php echo $item['des_motivo'] ?></td>
                    <td><?php echo $item['estado'] ?></td>
                    <td><?php echo $item['tipo'] ?></td>
                    <td style="text-align: center"><div class="btn-group" data-toggle="buttons"><button class="btn btn-primary btn-xs btnUpdate" dataID="<?php echo $item['motivo'];?>">Editar</button><button class="btn btn-danger btn-xs btnDelete" dataID="<?php echo $item['motivo'];?>">Eliminar</button></div></td>
                </tr>
            <?php endforeach;?>
            </tbody>
        </table>
        <div class="pull-right" id="btnAdd"><a class="btn btn-success action-btn" style="margin-bottom: 2px" action-btn-value="add">Agregar</a></div>
    </div>
    </div>
  </div>
</div>
</body>
</html>

<div id="add_model" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Agregar Motivo</h4>
            </div>
            <div class="modal-body">
                <form method="post" id="frm_add">
                    <input type="hidden" value="add" name="action" id="action">
                    <input type="hidden" value="0" name="data_id" id="data_id">
                  <div class="form-group">
                    <label for="motivo" class="control-label">Motivo:</label>
                    <input type="text" class="form-control" id="motivo" name="motivo"/>
                  </div>
                  <div class="form-group">
                    <label for="estado" class="control-label">Estado:</label>
                    <input type="text" class="form-control" id="estado" name="estado"/>
                  </div>
                  <div class="form-group">
                    <label for="tipo" class="control-label">Tipo:</label>
                    <input type="text" class="form-control" id="tipo" name="tipo"/>
                  </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="button" id="btn_add" class="btn btn-success">Guardar</button>
            </div>
        </div>
    </div>
</div>

<script>  
 $(document).ready(function(){  
      $('#datagrid').DataTable();  

      $("#btnAdd").on('click', function(){  
           $('.modal-title').html("Agregar Motivo");
           $('#action').val("add");  
           $('#data_id').val(0);
           $('#btn_add').html("Agregar");
           $('#add_model').modal('show');
      });

      $("#btn_add").click(function() {
        var data = $("#frm_add").serializeArray();
        $.post('response.php', { data: data, action : data[0].value}, function(resp, status){
            location.reload();
        }); 
      });

      $("#datagrid").on('click', '.btnDelete', function(){  
           var id = $(this).attr("dataID");
           var conf = confirm('Esta seguro de eliminar este item?');
            if(conf && id > 0){
                $.post('response.php', { id: id, action : 'delete'}, function(resp, status){
                    if (resp) {
                        location.reload();
                    } else {
                        $('#msg').html('<div class="alert alert-danger ">Error! No se elimino el item</div>');
                    }
                }); 
            } 
      });

      $("#datagrid").on('click', '.btnUpdate', function(){  
           var id = $(this).attr("dataID");
           $('.modal-title').html("Editar Item");
           $.ajax({  
                url:"response.php?action=get_data&id="+id,  
                method:"GET", 
                dataType:"json",  
                success:function(data){ 
                     $('#motivo').val(data.des_motivo);    
                     $('#estado').val(data.estado);
                     $('#tipo').val(data.tipo);
                     $('#data_id').val(data.motivo);  
                     $('#btn_add').html("Editar");
                     $('#action').val("edit");  
                     $('#add_model').modal('show');  
                }  
           });  
      });
 });  

function ajaxAction(action) {
    
    
    /*$.ajax({
        type: "POST",  
        url: "response.php",  
        data: data,
        dataType: "json",   
        crossOrigin: true,    
        success: function(response) {
            //console.log(response);
            $('#msg').html('');
            if(response.status) {
                $('#'+action+'_model').modal('hide');
                $('#msg').html('<div class="alert alert-success">Agregado correctamente</div>');
                $('#datagrid').DataTable().ajax.reload();
            } else {
                $('#msg').html('<div class="alert alert-danger ">Error! No se inserto</div>');	
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            $('#msg').html('<div class="alert alert-danger ">Error'+textStatus+'!'+errorThrown);
        }  
    });*/
}
</script>  
