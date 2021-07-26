<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Pesquisa</title>
  <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
  <script src="https://unpkg.com/axios/dist/axios.min.js"></script>

  <!-- Bootstrap  CSS -->
  <link type="text/css" rel="stylesheet" href="//unpkg.com/bootstrap/dist/css/bootstrap.min.css" />
  <!-- BootstrapVue CSS -->
  <link type="text/css" rel="stylesheet" href="//unpkg.com/bootstrap-vue@latest/dist/bootstrap-vue.min.css" />
  <style>
  .modal-mask {
    position: fixed;
    z-index: 9998;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, .5);
    display: table;
    transition: opacity .3s ease;
  }

  .modal-wrapper {
    display: table-cell;
    vertical-align: middle;
  }
  </style>
</head>

<body class=" bg-secondary main">
  <div id="crudApp">
    <div class="container-fluid">
      <div class="col-lg-12">
        <nav class="navbar navbar-light  ">
          <h1 class=" mb-0">Tarefa</h1>
          <div class="d-flex d-grid gap-2 d-md-block">
            <button class="btn btn-light" @click="openModel" value="Add">Dimensões</button>
            <button class="btn btn-primary" @click="openModel" value="Add">+ Criar pergunta</button>
          </div>
        </nav>
      </div>
    </div>
    <div class="container-fluid ">
      <div class="col-lg-12">
        <div class="card  mb-12 bg-light shadow borde-0 main-raised">
          <div class="card-header bg-light">
            <!-- <div class="row g-2">
              <div class="col-md-3">
                <div class="form-floating">
                  <select class="form-select" id="floatingSelectGrid" aria-label="Floating label select example">
                    <option selected>Selecione</option>
                    <option value="1">One</option>
                    <option value="2">Two</option>
                    <option value="3">Three</option>
                  </select>
                  <label for="floatingSelectGrid">Filtro</label>
                </div>
              </div>
            </div> -->
          </div>
          <div class="card-body">
            <table class="table table-bordered">
              <tbody>
                <tr v-for="row in allQuestions">
                  <!-- <td class="text-center" scope="row" style="width:  5%">
                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                  </td> -->
                  <td class="text-center">{{ row.dimension}}</td>
                  <td>{{row.question}}</td>
                  <td class="text-center" style="width:  20%">
                    <div class="d-flex d-grid gap-2 d-md-block">
                      <button type="button" name="edit" class="btn btn-primary btn-xs edit"
                        @click="fetchData(row.id_question)">Editar</button>
                      <button type="button" name="delete" class="btn btn-danger btn-xs delete"
                        @click="deleteData(row.id_question)">Excluir</button>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <div v-if="myModel">
      <transition name="model">
        <div class="modal-mask">
          <div class="modal-wrapper">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">{{ dynamicTitle }}</h4>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" @click="myModel=false"
                    aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <div class="form-group">
                    <label>Texto da pergunta</label>
                    <input type="text" class="form-control" v-model="question" />
                  </div>
                  <div class="form-group col-md-4">
                    <label>Dimensão</label>
                    <select class="form-select" v-model="selected">
                      <option v-for="option in options" v-bind:value="option.value">
                        {{ option.text }}
                      </option>                      
                    </select>
                  </div>
                  <input type="hidden" v-model="hiddenIdQuestion" />
                </div>
                <div class="modal-footer" align="center">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                    @click="myModel=false">Close</button>
                  <input type="button" class="btn btn-primary" v-model="actionButton" @click="submitData" />
                </div>
              </div>
            </div>
          </div>
        </div>
      </transition>
    </div>
  </div>
</body>

</html>

<script>
var application = new Vue({
  el: '#crudApp',
  data: {
    allQuestions: '',
    allDimensions: '',
    myModel: false,
    actionButton: 'Inserir',
    dynamicTitle: 'Criar pergunta',
    selected: '',
    options: [
      { text: 'Bem-estar', value: 1 },
      { text: 'Carreira', value: 2 },
      { text: 'Estrutura', value: 3 }
    ]
  },
  methods: {

    fetchAllQuestion: function() {
      axios.post('action.php', {
        action: 'fetchallQuestion'
      }).then(function(response) {
        application.allQuestions = response.data;
      });
    },
    fetchallDimensions: function() {
      axios.post('action.php', {
        action: 'fetchallDimensions'
      }).then(function(response) {
        application.allDimensions = response.data;
      });
    },
    openModel: function() {
      application.selected = '';
      application.question = '';
      application.hiddenIdQuestion = application.hiddenIdQuestion;
      application.actionButton = "Inserir";
      application.dynamicTitle = "Criar pergunta";
      application.myModel = true;
    },
    submitData: function() {
      if (application.selected != '' && application.question != '') {
        if (application.actionButton == 'Inserir') {
          axios.post('action.php', {
            action: 'insert',
            id_dimension: application.selected,
            question: application.question
          }).then(function(response) {
            application.myModel = false;
            application.fetchAllQuestion();
            application.selected = '';
            application.question = '';
            application.hiddenIdQuestion = '';
            alert(response.data.message);
          });
        }
        if (application.actionButton == 'Editar') {
          axios.post('action.php', {
            action: 'update',
            id_dimension: application.selected,
            question: application.question,
            hiddenIdQuestion: application.hiddenIdQuestion
          }).then(function(response) {
            application.myModel = false;
            application.fetchAllQuestion();
            application.selected = '';
            application.question = '';
            application.hiddenIdQuestion = '';
            alert(response.data.message);
            
          });
        }
      } else {
        alert("Preencha todos os dados");
      }
    },
    
    fetchData: function(id_question) {
      axios.post('action.php', {
        action: 'fetchSingle',
        id_question: id_question
      }).then(function(response) {
        application.selected=  response.data.id_dimension,
        application.question = response.data.question;
        application.hiddenIdQuestion = response.data.id_question;
        application.myModel = true;
        application.actionButton = 'Editar';
        application.dynamicTitle = 'Editar Pergunta';
      });
    },
    deleteData: function(id_question) {
      if (confirm("Are you sure you want to remove this data?")) {
        axios.post('action.php', {
          action: 'delete',
          id_question: id_question
        }).then(function(response) {
          application.fetchAllQuestion();
          alert(response.data.message);
        });
      }
    }
  },
  created: function() {
    this.fetchAllQuestion();
  }
});
</script>