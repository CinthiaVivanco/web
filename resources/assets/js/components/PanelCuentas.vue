<template>
  <!-- 
  <div class="be-content"   >-->
  <div class="main-content container-fluid">
    <div class="row">
      <div class="col-sm-12">
        <div class="panel panel-default panel-table">
          <div class="panel-heading">
            Cartera Cuentas
            <div class="tools">
              <span class="icon mdi mdi-download"></span>
              <span class="icon mdi mdi-more-vert"></span>
            </div>
          </div>
          <div class="col-md-6">
            
            <div class="email-search col-md-6" style="padding-top: 15px;">
                <select class="form-control input-sm" v-model="filtrojv">
                      <option value="">TODOS</option>
                      <option v-for="jv in ojefeVenta"  :key="jv.COD_CATEGORIA" v-bind:value="jv.COD_CATEGORIA" >
                            {{ jv.NOM_CATEGORIA }}
                      </option>
                </select>
            </div>
            <div class="email-search col-md-5" style="padding-top: 15px;">
              <div class="input-group input-search input-group-sm" style="padding-bottom: 50px;">
                <input
                  v-model="buscar"
                  type="text"
                  placeholder="Búsqueda personalizada..."
                  class="form-control"
                >
                <!-- <span class="input-group-btn">
                  <button
                    @click="listarCuentas(1,buscar,criterio)"
                    type="button"
                    class="btn btn-default"
                  >
                    <i class="icon mdi mdi-search"></i>
                  </button>
                </span> -->
              </div>
            </div>
            <div class="email-search col-md-1" style="padding-top: 19px;">
               <button  @click="listarCuentas(1,buscar,criterio,filtrojv)" class="btn btn-rounded btn-space btn-primary"><i class="icon icon-left mdi mdi-search"></i> Buscar </button>
            </div>
          </div>
          <div class="col-md-6">
            <nav>
              <ul class="pagination pull-right">
                <li v-if="pagination.current_page > 1">
                  <a
                    href="#"
                    @click.prevent="cambiarPagina(pagination.current_page -1,buscar,criterio,filtrojv)"
                    aria-label="Previous"
                  >
                    <span aria-hidden="true" class="mdi mdi-chevron-left"></span>
                  </a>
                </li>

                <li v-if="pagination.current_page < pagination.last_page">
                  <a
                    href="#"
                    @click.prevent="cambiarPagina(pagination.current_page + 1,buscar,criterio,filtrojv)"
                    aria-label="Next"
                  >
                    <span aria-hidden="true" class="mdi mdi-chevron-right"></span>
                  </a>
                </li>
              </ul>
            </nav>
          </div>
          <div class="col-md-12" style="padding-top: 15px;">
            <div class="widget-chart-info">
              <ul class="chart-legend-horizontal">
                <li>
                  <td class="text-center">
                    &nbsp;
                    <span class="badge badge-primary" v-text="pagination.total"></span>
                    <span class="text-primary">cuentas halladas</span>
                  </td>
                </li>
              </ul>
            </div>
          </div>
          <div class="panel-body">
            <table class="table table-striped table-hover">
              <thead>
                <tr>
                  <th style="width: 15%;text-align: center;">Cuenta</th>
                  <th style="width: 10%;text-align: center;">Representante Comercial</th>
                  <th style="width: 10%;text-align: center;">Canal</th>
                  <th style="width: 10%;text-align: center;">Subcanal</th>
                  <th style="width: 10%;text-align: center;">Condición Pago</th>
                  <th style="width: 15%;text-align: center;">Limite Crédito</th>
                  <th style="width: 15%;text-align: center;">Clasificacion</th>
                  <th style="width: 10%;text-align: center;"></th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="cuenta in oCuentas" :key="cuenta.COD_CONTRATO">
                  <td class="cell-detail">
                    <span v-text="cuenta.COD_CONTRATO"></span>
                    <span class="cell-detail-description" v-text="cuenta.CLIENTE"></span>
                  </td>
                  <td v-text="cuenta.RV"></td>
                  <td v-text="cuenta.CANAL"></td>
                  <td v-text="cuenta.SUBCANAL"></td>
                  <td class="text-center">
                    <span class="label label-primary" v-text="cuenta.CP"></span>
                  </td>
                  <!-- <td class="milestone">
                    
                    <span class="completed">10 / 30</span>
                    <span class="version" v-if="cuenta.CAN_LIMITE=='.00'"></span>
                    <span class="version" v-else >{{ formatPrice( cuenta.CAN_LIMITE)}}</span>
                    <div class="progress">
                      <div
                        style="width: 33%"
                        class="progress-bar"
                        :class="[cuenta.clasificacion=='M'? 'progress-bar-danger' : 'progress-bar-primary'] "
                        v-bind:style="[cuenta.clasificacion=='M'? '{ width: 100% }':'{33%}']"
                      ></div>
                    </div>
                  </td> -->
                  <td class="text-center">{{ formatPrice( cuenta.CAN_LIMITE)}}</td>
                  <td class="text-center">
                    <span
                      v-text="cuenta.clasificacion"
                      class="badge badge-success"
                      v-if="cuenta.clasificacion=='A'"
                    ></span>

                    <span
                      v-text="cuenta.clasificacion"
                      v-else
                      class="badge"
                      :class="[cuenta.clasificacion=='B'? 'badge-warning' : 'badge-danger'] "
                    ></span>
                  </td>
                  <td class="actions">
                    <div class="btn-group btn-hspace">
                      <button
                        type="button"
                        data-toggle="dropdown"
                        class="btn btn-primary"
                        aria-expanded="false"
                      >
                        <span class="icon-dropdown mdi mdi-settings"></span>
                      </button>
                      <ul role="menu" class="dropdown-menu pull-right">
                        <li>
                          <a
                            @click="AbrilModal('propiedadescuenta','editar',cuenta)"
                          >Cambiar límite de crédito</a>
                        </li>
                        <!-- <li><a href="#">Another action</a></li>
                                <li><a href="#">Something else here</a></li>
                                <li class="divider"></li>
                        <li><a href="#">Separated link</a></li>-->
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
    <!--Form Modals-->
    <div
      tabindex="-1"
      role="dialog"
      :class="{'mostrar' : modal}"
      class="modal fade colored-header colored-header-primary"
    >
      <div class="modal-dialog custom-width"     :class="{'mostrarsub' : modal}">
        <div class="modal-content">
          <div class="modal-header" style="padding: 30px 20px !important;">
            <button type="button" @click="cerrarModal()" aria-hidden="true" class="close md-close">
              <span class="mdi mdi-close"></span>
            </button>
            <h3 class="modal-title">{{oClienteActivo.nom}}</h3>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <table class="table table-striped table-hover">
                      <thead>
                        <tr>
                          <th style="width:37%;">Cuenta</th>
                          <th style="width:36%;">Responsable</th>
                          <th>Deuda</th>
                      
                        </tr>
                      </thead>
                      <tbody>
                         <tr v-for="cuentascli in oCuentasActivo" :key="cuentascli.COD_CONTRATO">
                             <td class="user-avatar">{{cuentascli.COD_CONTRATO}}</td>
                             <td>{{cuentascli.RV}}</td>
                             <td>{{formatPrice(15000)}}</td>
                         </tr>
                        <tr>
                          <td></td>
                          <td class="text-center"> <strong>Total</strong></td>
                          <td class="amount" >{{ formatPrice(15000) }}</td>
                        </tr>
                    
                      </tbody>
                    </table>
            </div>
            <div class="form-group">
              <div class="chart-legend">
                  <table>
                    <tbody>
                      <tr>
                        <td class="chart-legend-color"><span data-color="top-sales-color1" style="background-color: rgb(52, 168, 83);"></span></td>
                        <td>Clasificacion</td>
                        <td class="chart-legend-value">
                              <span v-text="oClienteActivo.clasificacion"
                                class="badge badge-success"
                                v-if="oClienteActivo.clasificacion=='A'"></span>

                              <span v-text="oClienteActivo.clasificacion" v-else class="badge"  :class="[oClienteActivo.clasificacion=='B'? 'badge-warning' : 'badge-danger'] " ></span>
                        </td>
                      </tr>
                      <tr>
                        <td class="chart-legend-color"><span data-color="top-sales-color2" style="background-color: rgb(251, 188, 5);"></span></td>
                        <td> Condición de Pago</td>
                        <td class="chart-legend-value pull-right">
                           <select v-model="oClienteActivo.condicionpago">
                              <option v-for="categoria in oCategoriaActivo"  :key="categoria.COD_CATEGORIA" v-bind:value="categoria.COD_CATEGORIA" :disabled="oClienteActivo.clasificacion == 'M' ? true : false">
                                {{ categoria.NOM_CATEGORIA }}
                              </option>
                            </select>
                        </td>
                      </tr>
                      <tr>
                        <td class="chart-legend-color"><span data-color="top-sales-color3" style="background-color: rgb(66, 133, 244);"></span></td>
                        <td>Límite de Crédito</td>
                        <td class="chart-legend-value pull-right">
                           <input class="form-control input-xs" v-model="oClienteActivo.limitecredito" v-bind:disabled="oClienteActivo.clasificacion == 'M' ? true : false"> 
                        </td>
                      </tr>
                    </tbody>
                  </table>
              </div>
            </div>
            
          </div>
          <div class="modal-footer">
            <button type="button" @click="cerrarModal()" class="btn btn-default md-close">Cancelar</button>
            <button type="button" @click="actualizarReglaCredito()" class="btn btn-primary md-close">Guardar</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- </div> -->
</template>

<script>

export default {
  props: ["ruta"],
  data() {
    return {
      oCuentas: [],
      pagination: {
        total: 0,
        current_page: 0,
        per_page: 0,
        last_page: 0,
        from: 0,
        to: 0
      },
      oClienteActivo: {
        cod:'',
        nom: '',
        limitecredito: 0,
        clasificacion: '',
        condicionpago: '',
        codreglacredito:''
      },
      oCuentasActivo:[],
      oCategoriaActivo:[],
      offset: 3,
      criterio: "Cliente",
      buscar: "",
      loading: false,
      modal: 0,
      ojefeVenta:[],
      filtrojv:''
    };
  },
  computed: {
    isActived: function() {
      return this.pagination.current_page;
    },
    //Calcula los elementos de la paginación
    pagesNumber: function() {
      if (!this.pagination.to) {
        return [];
      }

      var from = this.pagination.current_page - this.offset;
      if (from < 1) {
        from = 1;
      }

      var to = from + this.offset * 2;
      if (to >= this.pagination.last_page) {
        to = this.pagination.last_page;
      }

      var pagesArray = [];
      while (from <= to) {
        pagesArray.push(from);
        from++;
      }
      return pagesArray;
    }
  },
  methods: {
    listarCuentas(page, buscar, criterio,jv) {
      let me = this;
      var url =
        this.ruta +
        "/cartera?page=" +
        page +
        "&buscar=" +
        buscar +
        "&criterio=" +
        criterio+
        "&filtrojv=" +
        jv;
      axios
        .get(url)
        .then(function(response) {
          var respuesta = response.data;
          me.oCuentas = respuesta.cuentas.data;
          me.pagination = respuesta.pagination;
        })
        .catch(function(error) {
          console.log(error);
        });
    },
    listarCuentasCli(page, buscar, criterio) {
      let me = this;
      var url =
       this.ruta +
        "/cartera?page=" +
        page +
        "&buscar=" +
        buscar +
        "&criterio=" +
        criterio;
      axios
        .get(url)
        .then(function(response) {
          var respuesta = response.data;
          me.oCuentasActivo = respuesta.cuentas.data;
        })
        .catch(function(error) {
          console.log(error);
        });
    },
    listarCategoria(buscar) {
      let me = this;
      var url = this.ruta + "/categoria/listarCategoria?buscar="+buscar;
          axios
            .get(url)
            .then(function(response) {
              var res = response.data;
              me.oCategoriaActivo = res.categoria;
               
            })
            .catch(function(error) {
              console.log(error);
            });
    },
    listarJV(buscar) {
      let me = this;
      var url = this.ruta + "/categoria/listarCategoria?buscar="+buscar;
          axios
            .get(url)
            .then(function(response) {
              var res = response.data;
              me.ojefeVenta = res.categoria;
               
            })
            .catch(function(error) {
              console.log(error);
            });
    },
    cambiarPagina(page, buscar, criterio,filtrojv) {
      let me = this;
      //Actualiza la página actual
      me.pagination.current_page = page;
      //Envia la petición para visualizar la data de esa página
      me.listarCuentas(page, buscar, criterio,filtrojv);
    },
    actualizarReglaCredito(){
              //  if (this.validarCategoria()){
              //       return;
              //   }
                
                let me = this;

                axios.put(this.ruta + '/reglacredito/actualizar',{
                    'cliente': this.oClienteActivo.cod,
                    'clasificacion': this.oClienteActivo.clasificacion,
                    'condicionpago': this.oClienteActivo.condicionpago,
                    'limitecredito': this.oClienteActivo.limitecredito,
                    'reglacredito': this.oClienteActivo.codreglacredito
              
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarCuentas(me.pagination.current_page, me.buscar,me.criterio,me.filtrojv);
                    // console.log(me.buscar);
                }).catch(function (error) {
                    console.log(error);
                }); 
    },
    AbrilModal(modelo, accion, data = []) {
      switch (modelo) {
        case "propiedadescuenta":
          switch (accion) {
            case "editar":
              this.modal = 1;
              this.oClienteActivo.nom=data.CLIENTE;
              this.oClienteActivo.cod=data.CODCLIENTE;
              this.oClienteActivo.limitecredito=data.CAN_LIMITE;
              this.oClienteActivo.condicionpago=data.condicionpago_id;
              this.oClienteActivo.clasificacion=data.clasificacion;
              this.oClienteActivo.codreglacredito=data.id;
               
              this.listarCuentasCli(1, data.CODCLIENTE, 'codCliente');
              this.listarCategoria('TIPO_PAGO');

              break;
          }
          break;
      }
    },
    formatPrice(value) {
        let val = (value/1).toFixed(2).replace('.', ',')
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
    },
    cerrarModal(){
                this.modal=0;
            
            }
    },
    
    mounted() {
      this.listarCuentas(1, this.buscar, this.criterio,this.filtrojv);
      this.listarJV('JEFE_VENTA');
      //  console.log("MONTERICO");

      $(document).ready(function() {
        //initialize the javascript
        App.init();
      });
   }
};

</script>

<style>
.mostrarsub{
    -webkit-transform: translate(0, 0) !important;
    
     transform: translate(0, 0) !important;
    }
.mostrar {
 
  background-color: #3c29297a !important;

  display: block;
  padding-right: 16px;
  opacity: 1 !important;
  overflow-x: hidden;
  overflow-y: auto;
}
.div-error {
  display: flex;
  justify-content: center;
}
.text-error {
  color: red !important;
  font-weight: bold;
}
</style>
