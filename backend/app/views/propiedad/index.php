<?php  include("../header.php");?>
<script>
var app = angular.module('moduloCompras', ['ngRoute']);
angular.module('moduloCompras', ['ui.bootstrap']);
function controller($scope, $modal, $log , $http)
 {
    $scope.alerts = [];
    $scope.compra = [];
    $scope.comprasIniciales =[];
    $scope.detailComprasInit = [];
    $scope.users = [];

    angular.element(document).ready(function () {
        $http.post('./../../controllers/propiedad/propiedadFunctions.php', '{"action":"query"}').success(function(data){
            $scope.comprasIniciales = data;
         });
    });
    
    $scope.viewDetail = function (venta){
        $scope.showDetail = true;
        $('#dataTables-example1').on('click', 'tbody tr', function(event) {
                $(this).addClass('success').siblings().removeClass('success');
            });
        $http.post('./../../controllers/detalleCompra/detalleCompraFunctions.php', '{"action":"query" , "compra":'+JSON.stringify(venta)+'}').success(function(data){
            $scope.detailComprasInit = data;
         });
    };
    
    $scope.addProductsToDetail = function(size)
    {
        var modalProductsOpen = $modal.open({
            templateUrl:'myProductosModal.html',
            controller: productsModalController,
            size:size,
            resolve:{
                action:function(){
                    return "Insertar"
                },
                products:function(){
                    return $scope.detailComprasInit.productos;
                }

            }
        });

        modalProductsOpen.result.then(function (detalleCompra) {   
            $http.post('./../../controllers/detalleCompra/detalleCompraFunctions.php', '{"action":"insert","detalleCompra":'+JSON.stringify(detalleCompra)+',"compra":'+JSON.stringify($scope.detailComprasInit.compra)+'}').success(function(data){
                  $scope.detailComprasInit.detalleCompras.push(data);
            });             
        }, function () {});
    }
    
    $scope.alerts = [];
      $scope.closeAlert = function(index) {
        $scope.alerts.splice(index, 1);
      };
    
          $scope.deleteCompra = function (user){
         if(confirm("Esta apunto de eliminar una Propiedad \n Esto eliminara todas los detalles de la propiedad asignados a esta \n Desea continuar?")){
                    $scope.showDetail = false;
                    var index = $scope.comprasIniciales.compras.indexOf(user);
                    $http.post('./../../controllers/propiedad/propiedadFunctions.php','{"action":"delete","propiedad":'+JSON.stringify(user)+'}').success(function(data){
                       $scope.alerts.push({type: 'success', msg: 'Propiedad  Exitosamente Eliminada' });
                        $scope.comprasIniciales.compras.splice(index,1);

                  });
            }
        };  
        
            $scope.deleteDetail = function (detalle){
        if(confirm("Esta apunto de eliminar Desea continuar?")){
            $http.post('./../../controllers/detalleCompra/detalleCompraFunctions.php','{"action":"delete","detalleCompra":'+JSON.stringify(detalle)+'}').success(function(data){
                var index = $scope.detailComprasInit.detalleCompras.indexOf(detalle);
                $scope.alerts.push({type: 'success', msg: 'Detalle de Compra Exitosamente Eliminado' });
                $scope.detailComprasInit.detalleCompras.splice(index,1);
          });    
        }
    }
    
   
    $scope.showUpdateDialog = function (data,size){
        
    	var modalInstanceUpdate = $modal.open({
            templateUrl: 'myModalContent.html',
            controller: ModalInstanceUpdateCtrl,
            size: size,
            resolve: {
                action: function(){
                return "Modificar"
                }, 
                propiedad: function () {
                        return data;
                    }
          	}
        });
        modalInstanceUpdate.result.then(function (propiedad) {
            $http.post('./../../controllers/propiedad/propiedadFunctions.php', '{"action":"update","propiedad":'+JSON.stringify(propiedad)+'}').success(function(data){
                $scope.alerts.push({type: 'success', msg: 'Propiedad Modificada Exitosamente' });
             });
             
        }, function () {
        });
    } 
      
    $scope.openVentas = function (size) {
        var modalInstanceOpen = $modal.open({
          templateUrl: 'myModalContent.html',
          controller: ModalInstanceAddCtrl,
          size: size,
          resolve: {
            action: function(){
                return "Insertar"
            },
            users:function(){
                return $scope.comprasIniciales.usuarios;
            }
            }
        });

        modalInstanceOpen.result.then(function (gasto) {
            $http.post('./../../controllers/propiedad/propiedadFunctions.php', '{"action":"insert","propiedad":'+JSON.stringify(gasto)+'}').success(function(data){
                  $scope.comprasIniciales.compras.push(data);
                  $scope.alerts.push({type: 'success', msg: 'Propiedad Agregada Exitosamente' });
                
            });             
        }, function () {});
    };
 
     $scope.showDetailUpdateDialog = function (data,size){
        var modalInstanceDetailUpdate = $modal.open({
            templateUrl: 'myProductosModal.html',
            controller: ModalInstanceDetailUpdateCtrl,
            size: size,
            resolve: {
                action: function(){
                return "Modificar"
                }, 
                detalleVenta: function () {
                        return data;
                    },
                products:function(){
                    return $scope.detailComprasInit.productos;
                }
            }
        });
        modalInstanceDetailUpdate.result.then(function (detalle) {
            $http.post('./../../controllers/detalleCompra/detalleCompraFunctions.php', '{"action":"update","detalleCompra":'+JSON.stringify(detalle)+',"compra":'+JSON.stringify($scope.detailComprasInit.compras)+'}').success(function(data){
                $scope.alerts.push({type: 'success', msg: 'Detalle de Compra Modificado Exitosamente' });
             });
             
        }, function () {
        });
    };
    
 }
 
  var productsModalController = function ($scope,$http, $modalInstance,action,products) {
    $scope.products = products;
    $scope.detail ={};


    $scope.ok = function (valid) {
        if(valid){
            $modalInstance.close($scope.detail);
        } 
    };

    $scope.cancel = function () {
        $modalInstance.dismiss('cancel');
    };
 } 
    
  var ModalInstanceDetailUpdateCtrl = function($scope,$http, $modalInstance,action,detalleVenta,products){
    $scope.products = products;
    $scope.action = action;
    $scope.detail = detalleVenta;


    $scope.ok = function (valid) {
        if(valid){
            $modalInstance.close($scope.detail);
        } 
    };

    $scope.cancel = function () {
        $modalInstance.dismiss('cancel');
    };
 }
 
   var ModalInstanceUpdateCtrl = function ($scope,$http, $modalInstance,action,propiedad) {
    
    $scope.new = propiedad;
    $scope.action = action;
    $scope.tipos =["Apartamento","Bodega","Casa","Edificio","Local","Terreno"];
    $scope.negocios =["Venta","Renta"];
    $scope.zonas =["1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19","20","21"];
    $scope.departamentos = JSON.parse('{"departamentos":[{"nombre":"Alta Verapaz","municipios":["Chahal","Lanquín","San Juan Chamelco","Santa María Cahabón","Tucurú","Chisec","Panzós","San Pedro Carchá","Senahú","Cobán","Raxruhá","Santa Catalina La Tinta","Tactic","Fray Bartolomé de las Casas","San Cristóbal Verapaz","Santa Cruz Verapaz","Tamahú"]},{"nombre":"El Progreso","municipios":["El Jícaro","San Antonio La Paz","Guastatoya","San Cristóbal Acasaguastlán","Morazán","Sanarate","San Agustín Acasaguastlán","Sansare"]},{"nombre":"Izabal","municipios":["El Estor","Puerto Barrios","Livingston","Los Amates","Morales"]},{"nombre":"Quetzaltenango","municipios":["Almolonga","Coatepeque","Flores Costa Cuca","Olintepeque","San Carlos Sija","San Mateo","Cabricán","Colomba","Génova","Palestina de Los Altos","San Francisco La Unión","San Miguel Sigüilá","Cajolá","Concepción Chiquirichapa","Huitán","Quetzaltenango","San Juan Ostuncalco","Sibilia","Cantel","El Palmar","La Esperanza","Salcajá","San Martín Sacatepéquez","Zunil"]},{"nombre":"San Marcos","municipios":["Ayutla","El Quetzal","IxchiguánW","Ocós","San Cristóbal Cucho","San Miguel Ixtahuacán","Sibinal","Tejutla","Catarina","El Rodeo","La Reforma","Pajapita","San José Ojetenam","San Pablo","Sipacapa","Comitancillo","El Tumbador","Malacatán","Río Blanco","San Lorenzo","San Pedro Sacatepéquez","Tacaná","Concepción Tutuapa","Esquipulas Palo Gordo","Nuevo Progreso","San Antonio Sacatepéquez","San Marcos","San Rafael Pie de La Cuesta","Tajumulco"]},{"nombre":"Totonicapán","municipios":["Momostenango","San Francisco El Alto","San Andrés Xecul","Santa Lucía La Reforma","San Bartolo","Santa María Chiquimula","San Cristóbal Totonicapán","Totonicapán"]},{"nombre":"Baja Verapaz","municipios":["Cubulco","Salamá","Granados","San Jerónimo","Purulhá","San Miguel Chicaj","Rabinal","Santa Cruz el Chol"]},{"nombre":"Escuintla","municipios":["Escuintla","La Gomera","San José","Tiquisate","Guanagazapa","Masagua","San Vicente Pacaya","Iztapa","Nueva Concepción","Santa Lucía Cotzumalguapa","La Democracia","Palín","Siquinalá"]},{"nombre":"Jalapa","municipios":["Jalapa","San Luis Jilotepeque","Mataquescuintla","San Manuel Chaparrón","Monjas","San Pedro Pinula","San Carlos Alzatate"]},{"nombre":"Quiché","municipios":["Canillá","Chichicastenango","Joyabaj","Sacapulas","San Juan Cotzal","Zacualpa","Chajul","Chinique","Nebaj","San Andrés Sajcabajá","San Pedro Jocopilas","Chicamán","Cunén","Pachalum","San Antonio Ilotenango","Santa Cruz del Quiché","Chiché","Ixcán","Patzité","San Bartolomé Jocotenango","Uspantán"]},{"nombre":"Santa Rosa","municipios":["Barberena","Guazacapán","San Juan Tecuaco","Santa Rosa de Lima","Casillas","Nueva Santa Rosa","San Rafaél Las Flores","Taxisco","Chiquimulilla","Oratorio","Santa Cruz Naranjo","Cuilapa","Pueblo Nuevo Viñas","Santa María Ixhuatán"]},{"nombre":"Zacapa","municipios":["Cabañas","La Unión","Usumatlán","Estanzuela","Río Hondo","Zacapa","Gualán","San Diego","Huité","Teculután"]},{"nombre":"Chimaltenango","municipios":["Acatenango","Patzicía","San José Poaquil","Santa Cruz Balanyá","Chimaltenango","Patzún","San Juan Comalapa","Tecpán","El Tejar","Pochuta","San Martín Jilotepeque","Yepocapa","Parramos","San Andrés Itzapa","Santa Apolonia","Zaragoza"]},{"nombre":"Guatemala","municipios":["Amatitlán","Guatemala","San José Pinula","San Pedro Sacatepéquez","Villa Nueva","Chinautla","Mixco","San Juan Sacatepéquez","San Raymundo","Chuarrancho","Palencia","San Miguel Petapa","Santa Catarina Pinula","Fraijanes","San José del Golfo","San Pedro Ayampuc","Villa Canales"]},{"nombre":"Jutiapa","municipios":["Agua Blanca","Conguaco","Jerez","Quesada","Zapotitlán","Asunción Mita","El Adelanto","Jutiapa","San José Acatempa","Atescatempa","El Progreso","Moyuta","Santa Catarina Mita","Comapa","Jalpatagua","Pasaco","Yupiltepeque"]},{"nombre":"Retalhuleu","municipios":["Champerico","San Andrés Villa Seca","Santa Cruz Muluá","El Asintal","San Felipe","Nuevo San Carlos","San Martín Zapotitlán","Retalhuleu","San Sebastián"]},{"nombre":"Sololá","municipios":["Concepción","San Antonio Palopó","San Marcos La Laguna","Santa Catarina Palopó","Santa María Visitación","Nahualá","San José Chacayá","San Pablo La Laguna","Santa Clara La Laguna","Santiago Atitlán","Panajachel","San Juan La Laguna","San Pedro La Laguna","Santa Cruz La Laguna","Sololá","San Andrés Semetabaj","San Lucas Tolimán","Santa Catarina Ixtahuacan","Santa Lucía Utatlán"]},{"nombre":"Chiquimula","municipios":["Camotán","Ipala","San Jacinto","Chiquimula","Jocotán","San José La Arada","Concepción Las Minas","Olopa","San Juan Ermita","Esquipulas","Quezaltepeque"]},{"nombre":"Huehuetenango","municipios":["Aguacatán","Cuilco","La Libertad","San Gaspar Ixchil","San Mateo Ixtatán","San Rafael La Independencia","Santa Ana Huista","Santiago Chimaltenango","Chiantla","Huehuetenango","Malacatancito","San Ildefonso Ixtahuacán","San Miguel Acatán","San Rafael Petzal","Santa Bárbara","Tectitán","Colotenango","Jacaltenango","Nentón","San Juan Atitán","San Pedro Necta","San Sebastián Coatán","Santa Cruz Barillas","Todos Santos Cuchumatánes","Concepción Huista","La Democracia","San Antonio Huista","San Juan Ixcoy","San Pedro Soloma","San Sebastián","Santa Eulalia","Unión Cantinil"]},{"nombre":"Petén","municipios":["Dolores","Melchor de Mencos","San Francisco","Sayaxché","Flores","Poptún","San José","La Libertad","San Andrés","San Luis","Las Cruces","San Benito","Santa Ana"]},{"nombre":"Sacatepéquez","municipios":["Alotenango","Magdalena Milpas Altas","San Lucas Sacatepéquez","Santa María de Jesús","La Antigua Guatemala","Pastores","San Miguel Dueñas","Santiago Sacatepéquez","Ciudad Vieja","San Antonio Aguas Calientes","Santa Catarina Barahona","Santo Domingo Xenacoj","Jocotenango","San Bartolomé Milpas Altas","Santa Lucía Milpas Altas","Sumpango"]},{"nombre":"Suchitepéquez","municipios":["Chicacao","Pueblo Nuevo","San Bernardino","San Juan Bautista","Santa Bárbara","Cuyotenango","Río Bravo","San Francisco Zapotitlán","San Lorenzo","Santo Domingo","Mazatenango","Samayac","San Gabriel","San Miguel Panán","Santo Tomás La Unión","Patulul","San Antonio","San José El Ídolo","San Pablo Jocopilas","Zunilito"]}]}');
    
    $scope.$watch('new.dormitorios',function(val,old){
       $scope.new.dormitorios = parseFloat(val); 
    });
    $scope.$watch('new.precio_venta',function(val,old){
       $scope.new.precio_venta = parseFloat(val); 
    });
    $scope.$watch('new.precio_renta',function(val,old){
       $scope.new.precio_renta = parseFloat(val); 
    });
    $scope.$watch('new.area',function(val,old){
       $scope.new.area = parseFloat(val); 
    });
    $scope.$watch('new.area',function(val,old){
       $scope.new.area = parseFloat(val); 
    });
    var index = functiontofindIndexByKeyValue($scope.departamentos.departamentos,'nombre',propiedad.departamento);
    $scope.new.departamento = $scope.departamentos.departamentos[index];
    $scope.new.amueblado = (propiedad.amueblado === 'true');

    $scope.ok = function (valid) {
        if(valid){
            $modalInstance.close($scope.new);
        }
    };

    $scope.cancel = function () {
        $modalInstance.dismiss('cancel');
    };
    $scope.getMunicipios = function (departamento){
        return departamento.municipios;
    }
};

  var ModalInstanceAddCtrl = function ($scope,$http, $modalInstance,action,users) {
    $scope.users = users;
    $scope.action = action;
    $scope.new = {"amueblada":false,"directa_compartida":"Directa","status":"Disponible","departamento":{}};
    $scope.tipos =["Apartamento","Bodega","Casa","Edificio","Local","Terreno"];
    $scope.negocios =["Venta","Renta"];
    $scope.zonas =["1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19","20","21"];
    $scope.departamentos = JSON.parse('{"departamentos":[{"nombre":"Alta Verapaz","municipios":["Chahal","Lanquín","San Juan Chamelco","Santa María Cahabón","Tucurú","Chisec","Panzós","San Pedro Carchá","Senahú","Cobán","Raxruhá","Santa Catalina La Tinta","Tactic","Fray Bartolomé de las Casas","San Cristóbal Verapaz","Santa Cruz Verapaz","Tamahú"]},{"nombre":"El Progreso","municipios":["El Jícaro","San Antonio La Paz","Guastatoya","San Cristóbal Acasaguastlán","Morazán","Sanarate","San Agustín Acasaguastlán","Sansare"]},{"nombre":"Izabal","municipios":["El Estor","Puerto Barrios","Livingston","Los Amates","Morales"]},{"nombre":"Quetzaltenango","municipios":["Almolonga","Coatepeque","Flores Costa Cuca","Olintepeque","San Carlos Sija","San Mateo","Cabricán","Colomba","Génova","Palestina de Los Altos","San Francisco La Unión","San Miguel Sigüilá","Cajolá","Concepción Chiquirichapa","Huitán","Quetzaltenango","San Juan Ostuncalco","Sibilia","Cantel","El Palmar","La Esperanza","Salcajá","San Martín Sacatepéquez","Zunil"]},{"nombre":"San Marcos","municipios":["Ayutla","El Quetzal","IxchiguánW","Ocós","San Cristóbal Cucho","San Miguel Ixtahuacán","Sibinal","Tejutla","Catarina","El Rodeo","La Reforma","Pajapita","San José Ojetenam","San Pablo","Sipacapa","Comitancillo","El Tumbador","Malacatán","Río Blanco","San Lorenzo","San Pedro Sacatepéquez","Tacaná","Concepción Tutuapa","Esquipulas Palo Gordo","Nuevo Progreso","San Antonio Sacatepéquez","San Marcos","San Rafael Pie de La Cuesta","Tajumulco"]},{"nombre":"Totonicapán","municipios":["Momostenango","San Francisco El Alto","San Andrés Xecul","Santa Lucía La Reforma","San Bartolo","Santa María Chiquimula","San Cristóbal Totonicapán","Totonicapán"]},{"nombre":"Baja Verapaz","municipios":["Cubulco","Salamá","Granados","San Jerónimo","Purulhá","San Miguel Chicaj","Rabinal","Santa Cruz el Chol"]},{"nombre":"Escuintla","municipios":["Escuintla","La Gomera","San José","Tiquisate","Guanagazapa","Masagua","San Vicente Pacaya","Iztapa","Nueva Concepción","Santa Lucía Cotzumalguapa","La Democracia","Palín","Siquinalá"]},{"nombre":"Jalapa","municipios":["Jalapa","San Luis Jilotepeque","Mataquescuintla","San Manuel Chaparrón","Monjas","San Pedro Pinula","San Carlos Alzatate"]},{"nombre":"Quiché","municipios":["Canillá","Chichicastenango","Joyabaj","Sacapulas","San Juan Cotzal","Zacualpa","Chajul","Chinique","Nebaj","San Andrés Sajcabajá","San Pedro Jocopilas","Chicamán","Cunén","Pachalum","San Antonio Ilotenango","Santa Cruz del Quiché","Chiché","Ixcán","Patzité","San Bartolomé Jocotenango","Uspantán"]},{"nombre":"Santa Rosa","municipios":["Barberena","Guazacapán","San Juan Tecuaco","Santa Rosa de Lima","Casillas","Nueva Santa Rosa","San Rafaél Las Flores","Taxisco","Chiquimulilla","Oratorio","Santa Cruz Naranjo","Cuilapa","Pueblo Nuevo Viñas","Santa María Ixhuatán"]},{"nombre":"Zacapa","municipios":["Cabañas","La Unión","Usumatlán","Estanzuela","Río Hondo","Zacapa","Gualán","San Diego","Huité","Teculután"]},{"nombre":"Chimaltenango","municipios":["Acatenango","Patzicía","San José Poaquil","Santa Cruz Balanyá","Chimaltenango","Patzún","San Juan Comalapa","Tecpán","El Tejar","Pochuta","San Martín Jilotepeque","Yepocapa","Parramos","San Andrés Itzapa","Santa Apolonia","Zaragoza"]},{"nombre":"Guatemala","municipios":["Amatitlán","Guatemala","San José Pinula","San Pedro Sacatepéquez","Villa Nueva","Chinautla","Mixco","San Juan Sacatepéquez","San Raymundo","Chuarrancho","Palencia","San Miguel Petapa","Santa Catarina Pinula","Fraijanes","San José del Golfo","San Pedro Ayampuc","Villa Canales"]},{"nombre":"Jutiapa","municipios":["Agua Blanca","Conguaco","Jerez","Quesada","Zapotitlán","Asunción Mita","El Adelanto","Jutiapa","San José Acatempa","Atescatempa","El Progreso","Moyuta","Santa Catarina Mita","Comapa","Jalpatagua","Pasaco","Yupiltepeque"]},{"nombre":"Retalhuleu","municipios":["Champerico","San Andrés Villa Seca","Santa Cruz Muluá","El Asintal","San Felipe","Nuevo San Carlos","San Martín Zapotitlán","Retalhuleu","San Sebastián"]},{"nombre":"Sololá","municipios":["Concepción","San Antonio Palopó","San Marcos La Laguna","Santa Catarina Palopó","Santa María Visitación","Nahualá","San José Chacayá","San Pablo La Laguna","Santa Clara La Laguna","Santiago Atitlán","Panajachel","San Juan La Laguna","San Pedro La Laguna","Santa Cruz La Laguna","Sololá","San Andrés Semetabaj","San Lucas Tolimán","Santa Catarina Ixtahuacan","Santa Lucía Utatlán"]},{"nombre":"Chiquimula","municipios":["Camotán","Ipala","San Jacinto","Chiquimula","Jocotán","San José La Arada","Concepción Las Minas","Olopa","San Juan Ermita","Esquipulas","Quezaltepeque"]},{"nombre":"Huehuetenango","municipios":["Aguacatán","Cuilco","La Libertad","San Gaspar Ixchil","San Mateo Ixtatán","San Rafael La Independencia","Santa Ana Huista","Santiago Chimaltenango","Chiantla","Huehuetenango","Malacatancito","San Ildefonso Ixtahuacán","San Miguel Acatán","San Rafael Petzal","Santa Bárbara","Tectitán","Colotenango","Jacaltenango","Nentón","San Juan Atitán","San Pedro Necta","San Sebastián Coatán","Santa Cruz Barillas","Todos Santos Cuchumatánes","Concepción Huista","La Democracia","San Antonio Huista","San Juan Ixcoy","San Pedro Soloma","San Sebastián","Santa Eulalia","Unión Cantinil"]},{"nombre":"Petén","municipios":["Dolores","Melchor de Mencos","San Francisco","Sayaxché","Flores","Poptún","San José","La Libertad","San Andrés","San Luis","Las Cruces","San Benito","Santa Ana"]},{"nombre":"Sacatepéquez","municipios":["Alotenango","Magdalena Milpas Altas","San Lucas Sacatepéquez","Santa María de Jesús","La Antigua Guatemala","Pastores","San Miguel Dueñas","Santiago Sacatepéquez","Ciudad Vieja","San Antonio Aguas Calientes","Santa Catarina Barahona","Santo Domingo Xenacoj","Jocotenango","San Bartolomé Milpas Altas","Santa Lucía Milpas Altas","Sumpango"]},{"nombre":"Suchitepéquez","municipios":["Chicacao","Pueblo Nuevo","San Bernardino","San Juan Bautista","Santa Bárbara","Cuyotenango","Río Bravo","San Francisco Zapotitlán","San Lorenzo","Santo Domingo","Mazatenango","Samayac","San Gabriel","San Miguel Panán","Santo Tomás La Unión","Patulul","San Antonio","San José El Ídolo","San Pablo Jocopilas","Zunilito"]}]}');
    $scope.getMunicipios = function (departamento){
        return departamento.municipios;
    }
    $scope.ok = function (valid) {

        if(valid){

            $modalInstance.close($scope.new);
        } 
    };

    $scope.cancel = function () {
        $modalInstance.dismiss('cancel');
    };
};

function functiontofindIndexByKeyValue(arraytosearch, key, valuetosearch) {
  for (var i = 0; i < arraytosearch.length; i++) {
    if (arraytosearch[i][key] == valuetosearch) {
      return i;
    }
  }
  return null;
}
 

 </script>
 <div ng-app="moduloCompras">
     <div ng-controller="controller">
		<div class="row">
             <alert ng-repeat="alert in alerts" type="{{alert.type}}" close="closeAlert($index)">{{alert.msg}}</alert>
            <div class="col-lg-12">
		        <h1 class="page-header">Ingreso de Propiedades</h1>
            </div>
            <div class="col-lg-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Propiedad
                        <button class="btn btn-default pull-right btn-xs"  ng-click="openVentas('lg')">Nueva Propiedad</button>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="table-responsive" style="overflow-x:auto ; height:600px; overflow-y:autp">
                            <table class="table table-striped table-bordered table-hover" id="dataTables-example1">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Ambiente</th>
                                        <th>Negocio</th>
                                        <th>Zona</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody ng-show="comprasIniciales.compras.length > 0">
                                    <tr  class="odd gradeX" ng-repeat="compras in comprasIniciales.compras"> 
                                        <td>{{compras.id_propiedad}}</td>
                                        <td>{{compras.ambiente}}</td>
                                        <td>{{compras.negocio}}</td>
                                        <td>{{compras.zona}}</td>
                                        <td>
                                        	<div class="btn-group">
											  <button type="button" class="btn btn-default dropdown-toggle btn-xs" data-toggle="dropdown">
											    <i class="fa fa-cog"></i>  Acciones <span class="caret"></span>
											  </button>
											  <ul class="dropdown-menu" role="menu">
											    <li><a href="#" ng-click="showUpdateDialog(compras,'lg')"> <i class="fa fa-pencil-square-o"></i>  Editar</a></li>
											    <li><a href="#" ng-click="deleteCompra(compras)"> <i class="fa fa-minus-square"></i>  Eliminar</a></li>
                                                <li><a href="#" ng-click="viewDetail(compras)"> <i class="fa fa-list-alt"></i>  Ver Detalle</a></li>
											  </ul>
											</div>
                                    	</td>    
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>   
            </div>
             <div class="col-lg-6">
                <div class="panel panel-default" ng-show="showDetail">
                    <div class="panel-heading">
                        Detalle Propiedades
                        <button class="btn btn-default pull-right btn-xs"  ng-click="addProductsToDetail(compras)">Agregar Imagenes</button>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                        	<table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nombre</th>
                                            <th>Ubicacion</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr ng-repeat="detalle in detailComprasInit.detalleCompras" class="odd gradeX"> 
                                            <td>{{detalle.id_compra}}</td>
                                            <td>{{detalle.nombre}}</td>
                                            <td>{{detalle.cantidad}}</td>
                                            <td>
                                            	<div class="btn-group">
        										  <button type="button" class="btn btn-default dropdown-toggle btn-xs" data-toggle="dropdown">
        										    <i class="fa fa-cog"></i>  Acciones <span class="caret"></span>
        										  </button>
        										  <ul class="dropdown-menu" role="menu">
        										    <li><a href="#" ng-click="showDetailUpdateDialog(detalle)"> <i class="fa fa-pencil-square-o"></i>  Editar</a></li>
        										    <li><a href="#" ng-click="deleteDetail(detalle)"> <i class="fa fa-minus-square"></i>  Eliminar</a></li>
        										  </ul>
        										</div>
                                        	</td>    
                                        </tr>
                                    </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div> 
                </div>
<script type="text/ng-template" id="myModalContent.html">
    <div class="modal-header">
        <h3 class="modal-title"¨>{{action}} Propiedad</ h3>
    </div>
    <div class="modal-body">
        <form role="form" name="userForm">
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="userStatus">Tipo</label>
                        <select  name="tipo" ng-model="new.tipo" id="tipo"  required="true" class="form-control" ng-options="tipo for tipo in tipos"></select>
                        <div class="alert-danger" role="alert" ng-show="userForm.tipo.$error.required"><small>Este campo es requerido</small></div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="negocio">Negocio</label>
                        <select name="negocio" ng-model="new.negocio" id="negocio" placeholder="Negocio" required="true" class="form-control" ng-options="negocio for negocio in negocios"></select>
                        <div class="alert-danger" role="alert" ng-show="userForm.negocio.$error.required"><small>Este campo es requerido</small></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="zona">Zona</label>
                        <select name="zona" ng-model="new.zona" id="zona" placeholder="Zona" required="true" class="form-control" ng-options="zona for zona in zonas"></select>
                        <div class="alert-danger" role="alert" ng-show="userForm.zona.$error.required"><small>Este campo es requerido</small></div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="nombre_proyecto">Nombre Proyecto</label>
                        <input type="text" class="form-control" name="nombre_proyecto" required="true" ng-model="new.nombre_proyecto" id="nombre_proyecto" placeholder="Nombre del Proyecto"/>          
                        <div class="alert-danger" role="alert" ng-show="userForm.nombre_proyecto.$error.required"><small>Este campo es requerido</small></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="nombre_propietario">Nombre Propietario</label>
                        <input type="text" class="form-control" required="true" ng-model="new.nombre_propietario" name="nombre_propietario" id="nombre_propietario" placeholder="Nombre del Propietario"/>
                        <div class="alert-danger" role="alert" ng-show="userForm.nombre_propietario.$error.required"><small>Este campo es requerido</small></div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="dormitorios">Dormitorios</label>
                        <input class="form-control" type="number" integer required="true" ng-model="new.dormitorios" id="dormitorios" name="dormitorios" placeholder="Numero de Dormitorios"/>
                        <div class="alert-danger" role="alert" ng-show="userForm.dormitorios.$error.required || userForm.dormitorios.$error.integer"><small>Este campo es requerido o invalido</small></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="precio_renta">Precio Renta</label>
                        <input type="number" class="form-control" ng-model="new.precio_renta" required="true" name="precio_renta" id="precio_renta" placeholder="Precio de Renta"/>
                        <div class="alert-danger" role="alert" ng-show="userForm.precio_renta.$error.required  || userForm.precio_renta.$error.integer"><small>Este campo es requerido o invalido</small></div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="precio_venta">Precio Compra</label>
                        <input class="form-control" name="precio_venta" type="number" required="true" ng-model="new.precio_venta" id="precio_venta" placeholder="Precio de Venta"/>
                        <div class="alert-danger" role="alert" ng-show="userForm.precio_venta.$error.required || userForm.precio_venta.$error.integer"><small>Este campo es requerido</small></div>
                    </div>
                </div>
                
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="ambientes">Ambiente</label>
                        <input class="form-control" type="text"  required="true" ng-model="new.ambiente" id="ambientes" name="ambientes" placeholder="Ambiente"/>
                        <div class="alert-danger" role="alert" ng-show="userForm.ambientes.$error.required"><small>Este campo es requerido</small></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                   <div class="form-group">
                        <label for="area">Area</label>
                        <input class="form-control" name="area" type="number" required="true" ng-model="new.area" id="area" placeholder="Area"/>
                        <div class="alert-danger" role="alert" ng-show="userForm.area.$error.required || userForm.area.$error.integer"><small>Este campo es requerido</small></div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="direccion">Direccion</label>
                        <input type="text" class="form-control" required="true" ng-model="new.direccion" name="direccion" id="direccion" placeholder="Direccion"/>
                        <div class="alert-danger" role="alert" ng-show="userForm.direccion.$error.required"><small>Este campo es requerido</small></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="departamentos">Departamento</label>
                        <select name="departamentos" ng-model="new.departamento" id="departamentos"  required="true" class="form-control" ng-options="departamento.nombre for departamento in departamentos.departamentos"></select>
                        <div class="alert-danger" role="alert" ng-show="userForm.departamentos.$error.required"><small>Este campo es requerido</small></div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="municipios">Municipio</label>
                        <select name="municipio" ng-model="new.municipio" id="municipio"  required="true" class="form-control" ng-options="municipio for municipio in getMunicipios(new.departamento)"></select>
                        <div class="alert-danger" role="alert" ng-show="userForm.municipio.$error.required"><small>Este campo es requerido</small></div>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="checkbox">
                        <label>
                        <input type="checkbox"  ng-model="new.amueblado" id="amueblado" name="amueblado"/>
                        Amueblado</label>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="checkbox">
                        <label>
                        <input type="radio" name="directa_compartida" checked value="Directa" ng-model="new.directa_compartida" id="directa"/>
                        Directa</label>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="checkbox">
                        <label>
                        <input type="radio" name="directa_compartida" value="Compartida" ng-model="new.directa_compartida" id="compartida"/>
                        Compartida</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                </div>          
                <div class="col-lg-3">
                    <div class="checkbox">
                        <label>
                        <input type="radio" name="estado" checked value="Disponible" ng-model="new.estado" id="estado_disponible"/>
                        Disponible</label>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="checkbox">
                        <label>
                        <input type="radio" name="estado" value="No Disponible" ng-model="new.estado" id="estado_no_disponible"/>
                        No Disponible</label>
                    </div>
                </div>
            </div>     
        </form>
    </div>
    <div class="modal-footer">
        <button class="btn btn-primary" ng-click="ok(userForm.$valid)">OK</button>
        <button class="btn btn-warning" ng-click="cancel()">Cancel</button>
    </div>
</script>
                 <script type="text/ng-template" id="myProductosModal.html">
            <div class="modal-header">
                <h3 class="modal-title"¨>{{action}} Detalle Compra</h3>
            </div>
            <div class="modal-body">
                <form role="form" name="detailSales">
                    <div class="form-group">
                        <label for="exampleInputEmail12">Producto</label>
                        <div class="row" id="exampleInputEmail12">
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="asuntoNameField" ng-model="productFilter" id="asuntoID" placeholder="Filtrar Producto..." />
                            </div>
                            <div class="col-md-6">
                                <select id="user-product-option" name="selectProduct"  ng-required="true" ng-model="detail.id_producto" class="form-control"  ng-options="product.id_producto as product.nombre for product in products"></select>
                            </div>
                        </div>
                        <div class="alert-danger" role="alert" ng-show="detailSales.selectProduct.$error.required"><small>Este campo es requerido</small></div>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Precio</label>
                        <input type="number" class="form-control" name="precio" ng-model="detail.precio" id="asuntoID" placeholder="Precio"  ng-required="true"/>
                        <div class="alert-danger" role="alert" ng-show="detailSales.precio.$error.required || detailSales.precio.$error.number"><small>Este campo es requerido</small> o incorrecto</div>
                    </div>
                    <div class="form-group">
                        <label for="user-rol-option">Cantidad</label>
                        <input type="number" class="form-control" name="cantidad" ng-model="detail.cantidad" id="comentarioID" placeholder="cantidad" ng-required="true"/>
                        <div class="alert-danger" role="alert" ng-show="detailSales.cantidad.$error.required  || detailSales.cantidad.$error.number"><small>Este campo es requerido</small> o incorrecto</div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" ng-click="ok(detailSales.$valid)">OK</button>
                <button class="btn btn-warning" ng-click="cancel()">Cancel</button>
            </div>
        </script>
            </div>      
        </div>
<?php  include("../footer.php"); ?>
