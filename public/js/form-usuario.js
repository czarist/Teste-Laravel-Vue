"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["form-usuario"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/admin/coordenador/FormCoordenador.vue?vue&type=script&lang=js&":
/*!****************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/admin/coordenador/FormCoordenador.vue?vue&type=script&lang=js& ***!
  \****************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _mixins_global_mixins__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../mixins/global-mixins */ "./resources/js/components/mixins/global-mixins.js");


function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }

function _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err); } _next(undefined); }); }; }

//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ['selected', 'id'],
  mixins: [_mixins_global_mixins__WEBPACK_IMPORTED_MODULE_1__["default"]],
  data: function data() {
    return {
      baseUrl: "http://127.0.0.1:8000",
      loading: false,
      verify: null,
      divisoes_tematicas: [{
        text: "Cinema e Audiovisual",
        value: "Cinema e Audiovisual"
      }, {
        text: "Jornalismo",
        value: "Jornalismo"
      }, {
        text: "Produção Transdisciplinar",
        value: "Produção Transdisciplinar"
      }, {
        text: "Publicidade e Propaganda",
        value: "Publicidade e Propaganda"
      }, {
        text: "Rádio, TV e Internet",
        value: "Rádio, TV e Internet"
      }, {
        text: "Relações Públicas",
        value: "Relações Públicas"
      }],
      tipo_expocom: false,
      post: {
        id: null,
        user_id: null,
        name: null,
        dt: null,
        ano: null,
        tipo: null,
        geral: null,
        _method: 'post'
      },
      options: [{
        text: 'Não',
        value: 0
      }, {
        text: 'Sim',
        value: 1
      }],
      tipos: [{
        text: 'Expocom',
        value: "Expocom"
      }, {
        text: 'Divisões Tematicas',
        value: "Divisões Tematicas"
      }, {
        text: 'Intercom Junior',
        value: "Intercom Junior"
      }, {
        text: 'Mesa',
        value: "Mesa"
      }],
      regioes: [{
        text: 'Norte',
        value: "Norte"
      }, {
        text: 'Nordeste',
        value: "Nordeste"
      }, {
        text: 'Sul',
        value: 'Sul'
      }, {
        text: 'Sudeste',
        value: "Sudeste"
      }, {
        text: 'Centro Oeste',
        value: "Centro Oeste"
      }]
    };
  },
  watch: {
    selected: function selected() {
      if (this.selected) {
        this.$forceUpdate();
        this.post.user_id = this.selected.id;
        this.post.id = this.selected && this.selected.coordenador_regional && this.selected.coordenador_regional ? this.selected.coordenador_regional.id : null;
        this.post.name = this.selected.name ? this.selected.name : null;
        this.post.tipo = this.selected && this.selected.coordenador_regional && this.selected.coordenador_regional ? this.selected.coordenador_regional.tipo : null;
        this.post.regiao = this.selected && this.selected.coordenador_regional && this.selected.coordenador_regional ? this.selected.coordenador_regional.regiao : null;
        this.post.dt = this.selected && this.selected.coordenador_regional ? this.selected.coordenador_regional.dt : null;
        this.post.ano = this.selected && this.selected.coordenador_regional && this.selected.coordenador_regional ? this.selected.coordenador_regional.ano : null;
        this.post.geral = this.selected && this.selected.coordenador_regional && this.selected.coordenador_regional ? this.selected.coordenador_regional.geral : null;
        this.post._method = this.post && this.post.id ? 'put' : 'post';
      } else {
        this.clear();
      }
    },
    post: {
      handler: function handler(newVal) {
        this.tipo_expocom = newVal.tipo == 'Expocom' ? true : false; // this.tipo_ij = newVal.tipo == 'Intercom Junior' ? true : false 

        if (this.tipo_expocom == true) {
          this.$validator.pause('regiao');
        }
      },
      deep: true
    }
  },
  computed: {
    url: function url() {
      return this.post && this.post.id ? "/".concat(this.post.id) : '';
    }
  },
  methods: {
    save: function save() {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                _this.loading = true;

                if (!(_this.post.dt == null && _this.post.tipo == "Expocom")) {
                  _context.next = 7;
                  break;
                }

                _this.message('Erro', 'Selecione uma divisão temática apenas!', 'error');

                _this.loading = false;
                return _context.abrupt("return");

              case 7:
                _context.next = 9;
                return _this.$validator.validateAll().then(function (valid) {
                  if (valid) {
                    _this.message('Aguarde...', 'Estamos salvando suas informações', 'info', -1);

                    setTimeout(function () {
                      axios.post("".concat("http://127.0.0.1:8000", "/admin/coordenador").concat(_this.url), _this.post).then(function (res) {
                        _this.clear();

                        if (res.success == "success") {
                          window.location.reload();
                          _this.loading = false;

                          _this.$emit('store', res.data.response);
                        } else {
                          window.location.reload();
                          _this.loading = false;

                          _this.$emit('update', res.data.response);
                        }

                        _this.message('Sucesso', res.success == "success" ? 'Usuário cadastrado.' : 'Usuário atualizado.', 'success');
                      })["catch"](function (error) {
                        if (error.response.status == 422) {
                          if (error.response.data.message == "The given data was invalid.") {
                            _this.loading = false;
                            return _this.message('Campos Obrigatórios', 'Preencha todos os campos obrigatórios', 'error');
                          }
                        }

                        if (error.response.status == 500) {
                          _this.loading = false;

                          _this.message('Erro', 'Por favor tente novamente.', 'error');
                        }

                        if (error.response.status == 403) {
                          if (error.response.data.message == "This action is unauthorized.") {
                            _this.loading = false;

                            _this.message('Erro', 'Ação não autorizada.', 'error');
                          }
                        }
                      });
                    }, 1000);
                  } else {
                    _this.loading = false;

                    _this.message('Campos Obrigatórios', 'Preencha todos os campos obrigatórios', 'error');
                  }
                });

              case 9:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    },
    clear: function clear() {
      this.post.id = null;
      this.post.name = null;
      this.post._method = 'post';
      this.$validator.reset('name');
    }
  },
  created: function created() {}
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/admin/coordenador_nacional/FormCoordenador.vue?vue&type=script&lang=js&":
/*!*************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/admin/coordenador_nacional/FormCoordenador.vue?vue&type=script&lang=js& ***!
  \*************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _mixins_global_mixins__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../mixins/global-mixins */ "./resources/js/components/mixins/global-mixins.js");


function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }

function _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err); } _next(undefined); }); }; }

//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ['selected', 'id'],
  mixins: [_mixins_global_mixins__WEBPACK_IMPORTED_MODULE_1__["default"]],
  data: function data() {
    return {
      baseUrl: "http://127.0.0.1:8000",
      loading: false,
      verify: null,
      gps: [],
      divisoes_tematicas_jr: [],
      divisoes_tematicas: [],
      tipo_expocom: false,
      post: {
        id: null,
        user_id: null,
        name: null,
        tipo: null,
        gps: null,
        ij: null,
        dt: null,
        ano: null,
        geral: null,
        _method: 'post'
      },
      options: [{
        text: 'Não',
        value: 0
      }, {
        text: 'Sim',
        value: 1
      }],
      tipos: [{
        text: 'GPs',
        value: 1
      }, {
        text: 'Intercom Junior',
        value: 2
      }, {
        text: 'Expocom',
        value: 3
      }, {
        text: 'Publicom',
        value: 4
      }]
    };
  },
  watch: {
    selected: function selected() {
      if (this.selected) {
        this.$forceUpdate();
        this.post.user_id = this.selected.id;
        this.post.id = this.selected && this.selected.coordenador_nacional && this.selected.coordenador_nacional ? this.selected.coordenador_nacional.id : null;
        this.post.name = this.selected.name ? this.selected.name : null;
        this.post.tipo = this.selected && this.selected.coordenador_nacional && this.selected.coordenador_nacional ? this.selected.coordenador_nacional.tipo : null;
        this.post.dt = this.selected && this.selected.coordenador_nacional ? this.selected.coordenador_nacional.dt : null;
        this.post.gps = this.selected && this.selected.coordenador_nacional ? this.selected.coordenador_nacional.gps : null;
        this.post.ij = this.selected && this.selected.coordenador_nacional ? this.selected.coordenador_nacional.ij : null;
        this.post.ano = this.selected && this.selected.coordenador_nacional ? this.selected.coordenador_nacional.ano : null;
        this.post.geral = this.selected && this.selected.coordenador_nacional ? this.selected.coordenador_nacional.geral : null;
        this.post._method = this.post && this.post.id ? 'put' : 'post';
      } else {
        this.clear();
      }
    },
    post: {
      handler: function handler(newVal) {
        this.tipo_expocom = newVal.tipo == 'Expocom' ? true : false; // this.tipo_ij = newVal.tipo == 'Intercom Junior' ? true : false 

        if (this.tipo_expocom == true) {
          this.$validator.pause('regiao');
        }
      },
      deep: true
    }
  },
  computed: {
    url: function url() {
      return this.post && this.post.id ? "/".concat(this.post.id) : '';
    }
  },
  methods: {
    save: function save() {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                _this.loading = true;

                if (!(_this.post.dt == null && _this.post.tipo == 3)) {
                  _context.next = 7;
                  break;
                }

                _this.message('Erro', 'Selecione uma divisão temática apenas!', 'error');

                _this.loading = false;
                return _context.abrupt("return");

              case 7:
                _context.next = 9;
                return _this.$validator.validateAll().then(function (valid) {
                  if (valid) {
                    _this.message('Aguarde...', 'Estamos salvando suas informações', 'info', -1);

                    setTimeout(function () {
                      axios.post("".concat("http://127.0.0.1:8000", "/admin/coordenador_nacional").concat(_this.url), _this.post).then(function (res) {
                        _this.clear();

                        if (res.success == "success") {
                          window.location.reload();
                          _this.loading = false;

                          _this.$emit('store', res.data.response);
                        } else {
                          window.location.reload();
                          _this.loading = false;

                          _this.$emit('update', res.data.response);
                        }

                        _this.message('Sucesso', res.success == "success" ? 'Usuário cadastrado.' : 'Usuário atualizado.', 'success');
                      })["catch"](function (error) {
                        if (error.response.status == 422) {
                          _this.loading = false;
                          return _this.message('Campos Obrigatórios', 'Preencha todos os campos obrigatórios', 'error');
                        }

                        if (error.response.status == 500) {
                          _this.loading = false;

                          _this.message('Erro', 'Por favor tente novamente.', 'error');
                        }

                        if (error.response.status == 403) {
                          if (error.response.data.message == "This action is unauthorized.") {
                            _this.loading = false;

                            _this.message('Erro', 'Ação não autorizada.', 'error');
                          }
                        }
                      });
                    }, 1000);
                  } else {
                    _this.loading = false;

                    _this.message('Campos Obrigatórios', 'Preencha todos os campos obrigatórios', 'error');
                  }
                });

              case 9:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    },
    clear: function clear() {
      this.post.id = null;
      this.post.name = null;
      this.post._method = 'post';
      this.$validator.reset('name');
    },
    getDivisoesTematicas: function getDivisoesTematicas() {
      var _this2 = this;

      var urlgetDivisoesTematicas = this.baseUrl + "/get/divisoes-tematicas";
      $.ajax({
        method: "GET",
        url: urlgetDivisoesTematicas,
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        dataType: 'json',
        success: function success(res) {
          _this2.divisoes_tematicas = res;
        },
        error: function error(res) {
          console.log(res);
        }
      });
    },
    getDivisoesTematicasJr: function getDivisoesTematicasJr() {
      var _this3 = this;

      var urlgetDivisoesTematicasJr = this.baseUrl + "/get/divisoes-tematicas-jr";
      $.ajax({
        method: "GET",
        url: urlgetDivisoesTematicasJr,
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        dataType: 'json',
        success: function success(res) {
          _this3.divisoes_tematicas_jr = res;
        },
        error: function error(res) {
          console.log(res);
        }
      });
    },
    getGp: function getGp() {
      var _this4 = this;

      var urlgetgp = this.baseUrl + "/get/gp";
      $.ajax({
        method: "GET",
        url: urlgetgp,
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        dataType: 'json',
        success: function success(res) {
          _this4.gps = res;
        },
        error: function error(res) {
          console.log(res);
        }
      });
    }
  },
  created: function created() {
    this.getDivisoesTematicas(), this.getDivisoesTematicasJr(), this.getGp();
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/admin/usuario/FormUsuario.vue?vue&type=script&lang=js&":
/*!********************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/admin/usuario/FormUsuario.vue?vue&type=script&lang=js& ***!
  \********************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _mixins_global_mixins__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../mixins/global-mixins */ "./resources/js/components/mixins/global-mixins.js");


function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }

function _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err); } _next(undefined); }); }; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ['selected', 'id'],
  mixins: [_mixins_global_mixins__WEBPACK_IMPORTED_MODULE_1__["default"]],
  data: function data() {
    var _ref;

    return _ref = {
      loading: false,
      acessos: [],
      estados: [],
      municipios: [],
      generos: [],
      usersTypes: [],
      tipos_isencoes: [],
      location: null,
      verify: null,
      paises: [],
      titulacoes: [],
      instituicoes: []
    }, _defineProperty(_ref, "titulacoes", []), _defineProperty(_ref, "showHidePasswod", false), _defineProperty(_ref, "showPassaword", "password"), _defineProperty(_ref, "post", {
      id: null,
      name: null,
      email: null,
      password: null,
      estrangeiro: 0,
      data_nascimento: null,
      orgao_expedidor: null,
      cpf: null,
      rg: null,
      telefone: null,
      celular: null,
      sexo_id: null,
      instituicao_id: null,
      titulacao_id: null,
      anuidade: null,
      numero_socio: null,
      obs_isentamos: null,
      todos_tipos_id: 3,
      todos_isencoes_id: null,
      ativo: 0,
      acessos: [],
      enderecos: {
        id: null,
        cep: null,
        logradouro: null,
        numero: null,
        complemento: null,
        bairro: null,
        municipio: null,
        estado: null,
        pais: null
      },
      _method: 'post'
    }), _defineProperty(_ref, "options", [{
      text: 'Não',
      value: 0
    }, {
      text: 'Sim',
      value: 1
    }]), _ref;
  },
  watch: {
    selected: function selected() {
      if (this.selected) {
        this.$forceUpdate();
        this.post.id = this.selected && this.selected.id;
        this.post.name = this.selected && this.selected.name;
        this.post.email = this.selected && this.selected.email;
        this.post.todos_tipos_id = this.filterTipoUser;
        this.post.todos_isencoes_id = this.filterTipoIsencao;
        this.post.ativo = this.selected && this.selected.ativo;
        this.post.acessos = this.access;
        this.post._method = 'put';
        this.post.data_nascimento = this.selected && this.selected.data_nascimento;
        this.post.orgao_expedidor = this.selected && this.selected.orgao_expedidor;
        this.post.cpf = this.selected && this.selected.cpf;
        this.post.rg = this.selected && this.selected.rg;
        this.post.telefone = this.selected && this.selected.telefone;
        this.post.celular = this.selected && this.selected.celular;
        this.post.sexo_id = this.selected && this.selected.sexo_id;
        this.post.anuidade = this.selected && this.selected.associado ? this.selected.associado.anuidade : null;
        this.post.numero_socio = this.selected && this.selected.associado ? this.selected.associado.numero_socio : null;
        this.post.obs_isentamos = this.selected && this.selected.associado ? this.selected.associado.obs_isentamos : null;
        this.post.instituicao_id = this.selected.associado ? this.selected.associado.instituicao_id : null;
        this.post.titulacao_id = this.selected.associado ? this.selected.associado.titulacao_id : null;
        this.post.enderecos = {
          id: this.selected && this.selected.enderecos && this.selected.enderecos[0] ? this.selected.enderecos[0].id : null,
          cep: this.selected && this.selected.enderecos && this.selected.enderecos[0] ? this.selected.enderecos[0].cep : null,
          logradouro: this.selected && this.selected.enderecos && this.selected.enderecos[0] ? this.selected.enderecos[0].logradouro : null,
          numero: this.selected && this.selected.enderecos && this.selected.enderecos[0] ? this.selected.enderecos[0].numero : null,
          complemento: this.selected && this.selected.enderecos && this.selected.enderecos[0] ? this.selected.enderecos[0].complemento : null,
          bairro: this.selected && this.selected.enderecos && this.selected.enderecos[0] ? this.selected.enderecos[0].bairro : null,
          pais: this.selected && this.selected.enderecos && this.selected.enderecos[0] ? this.selected.enderecos[0].pais_id : null,
          municipio: this.selected && this.selected.enderecos && this.selected.enderecos[0] && this.selected.enderecos[0].municipio ? this.selected.enderecos[0].municipio : null,
          estado: this.selected && this.selected.enderecos && this.selected.enderecos[0] && this.selected.enderecos[0].municipio ? this.selected.enderecos[0].municipio.estado : null
        };
      } else {
        this.clear();
      }
    },
    showHidePasswod: function showHidePasswod() {
      this.showPassaword = this.showHidePasswod == true ? 'text' : 'password';
    }
  },
  computed: {
    access: function access() {
      return this.selected && this.selected.acessos ? this.selected.acessos.map(function (res) {
        return res.id;
      }) : [];
    },
    filterTipoUser: function filterTipoUser() {
      return this.selected && this.selected.todos_tipos ? this.selected.todos_tipos.map(function (res) {
        return res.id;
      }) : [];
    },
    filterTipoIsencao: function filterTipoIsencao() {
      return this.selected && this.selected.todos_tipos_isencao ? this.selected.todos_tipos_isencao.map(function (res) {
        return res.id;
      }) : [];
    },
    passRequired: function passRequired() {
      return this.post && this.post.id ? false : true;
    },
    url: function url() {
      return this.post && this.post.id ? "/".concat(this.post.id) : '';
    }
  },
  methods: {
    getEstados: function getEstados() {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                _context.next = 2;
                return axios.get("".concat("http://127.0.0.1:8000", "/get/estados")).then(function (res) {
                  _this.estados = res.data;
                });

              case 2:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    },
    getMunicipios: function getMunicipios() {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                if (!(_this2.post.enderecos && _this2.post.enderecos.estado)) {
                  _context2.next = 3;
                  break;
                }

                _context2.next = 3;
                return axios.get("".concat("http://127.0.0.1:8000", "/get/municipios/").concat(_this2.post.enderecos.estado.id)).then(function (res) {
                  _this2.municipios = res.data;
                }).then(function () {
                  if (_this2.selected && _this2.selected.enderecos) {
                    _this2.post.enderecos.municipio = _this2.municipios.find(function (municipio) {
                      return municipio.nome == _this2.selected.enderecos[0].municipio.nome;
                    });

                    _this2.$validator.reset("municipio");
                  }
                });

              case 3:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      }))();
    },
    getCep: function getCep() {
      var _this3 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee3() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee3$(_context3) {
          while (1) {
            switch (_context3.prev = _context3.next) {
              case 0:
                if (!(_this3.post.enderecos.cep.length > 8)) {
                  _context3.next = 7;
                  break;
                }

                _context3.next = 3;
                return fetch("https://viacep.com.br/ws/".concat(_this3.post.enderecos.cep, "/json")).then(function (res) {
                  return res.json();
                }).then(function (res) {
                  _this3.post.enderecos = {
                    cep: _this3.post.enderecos.cep,
                    logradouro: res.logradouro,
                    bairro: res.bairro,
                    estado: _this3.estados.find(function (uf) {
                      return uf.sigla == res.uf;
                    }),
                    municipio: null,
                    id: _this3.post.enderecos.id,
                    numero: _this3.post.enderecos.numero,
                    complemento: null,
                    deleted: false
                  };
                  _this3.location = res.localidade;

                  if (res.erro == true) {
                    _this3.$notify({
                      group: "submit",
                      title: "Erro",
                      text: 'Endereço não encontrado!, tente novamente.',
                      type: "error"
                    });

                    _this3.loading = false;
                  }
                });

              case 3:
                _context3.next = 5;
                return _this3.getMunicipios();

              case 5:
                _this3.post.enderecos.municipio = _this3.municipios.find(function (municipio) {
                  return municipio.nome == _this3.location;
                });

                _this3.$forceUpdate();

              case 7:
              case "end":
                return _context3.stop();
            }
          }
        }, _callee3);
      }))();
    },
    save: function save() {
      var _this4 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee4() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee4$(_context4) {
          while (1) {
            switch (_context4.prev = _context4.next) {
              case 0:
                _this4.loading = true;
                _context4.next = 3;
                return _this4.$validator.validateAll().then(function (valid) {
                  if (valid) {
                    _this4.message('Aguarde...', 'Estamos salvando suas informações', 'info', -1);

                    setTimeout(function () {
                      axios.post("".concat("http://127.0.0.1:8000", "/admin/usuarios").concat(_this4.url), _this4.post).then(function (res) {
                        _this4.clear();

                        if (res.status == 201) {
                          _this4.loading = false;

                          _this4.$emit('store', res.data.response);
                        }

                        if (res.status == 200) {
                          _this4.loading = false;

                          _this4.$emit('update', res.data.response);
                        }

                        _this4.message('Sucesso', res.status == 201 ? 'Usuário cadastrado.' : 'Usuário atualizado.', 'success');
                      })["catch"](function (error) {
                        if (error.response.status == 422) {
                          if (error.response.data.message == "The given data was invalid.") {
                            _this4.loading = false;
                            return _this4.message('Campos Obrigatórios', 'Preencha todos os campos obrigatórios', 'error');
                          }
                        }

                        if (error.response.status == 500) {
                          _this4.loading = false;

                          _this4.message('Erro', 'Por favor tente novamente.', 'error');
                        }

                        if (error.response.status == 403) {
                          if (error.response.data.message == "This action is unauthorized.") {
                            _this4.loading = false;

                            _this4.message('Erro', 'Ação não autorizada.', 'error');
                          }
                        }
                      });
                    }, 1000);
                  } else {
                    _this4.loading = false;

                    _this4.message('Campos Obrigatórios', 'Preencha todos os campos obrigatórios', 'error');
                  }
                });

              case 3:
              case "end":
                return _context4.stop();
            }
          }
        }, _callee4);
      }))();
    },
    clear: function clear() {
      this.post.id = null;
      this.post.name = null;
      this.post.email = null;
      this.post.todos_tipos_id = 3;
      this.post.todos_isencoes_id = null;
      this.post.ativo = 0;
      this.post.acessos = [], this.post._method = 'post';
      this.post.data_nascimento = null;
      this.post.orgao_expedidor = null;
      this.post.cpf = null;
      this.post.rg = null;
      this.post.telefone = null;
      this.post.celular = null;
      this.post.sexo_id = null;
      this.post.anuidade = null;
      this.post.numero_socio = null;
      this.post.obs_isentamos = null;
      this.post.instituicao_id = null;
      this.post.titulacao_id = null;
      this.post.enderecos = {
        id: null,
        cep: null,
        logradouro: null,
        numero: null,
        complemento: null,
        bairro: null,
        municipio: null,
        estado: null,
        pais: null
      }, this.$validator.reset('name');
      this.$validator.reset('email');
    }
  },
  created: function created() {
    var _this5 = this;

    axios.get("http://127.0.0.1:8000" + '/get/tiposusuarios').then(function (res) {
      _this5.usersTypes = res.data;
    });
    axios.get("http://127.0.0.1:8000" + '/get/tipo_isencao').then(function (res) {
      _this5.tipos_isencoes = res.data;
    });
    axios.get("http://127.0.0.1:8000" + '/get/acessos').then(function (res) {
      _this5.acessos = res.data;
    });
    axios.get("http://127.0.0.1:8000" + '/get/tiposexo').then(function (res) {
      _this5.generos = res.data;
    });
    axios.get("".concat("http://127.0.0.1:8000", "/get/instituicoes")).then(function (res) {
      _this5.instituicoes = res.data;
    });
    axios.get("".concat("http://127.0.0.1:8000", "/get/titulacoes")).then(function (res) {
      _this5.titulacoes = res.data;
    });
    this.getEstados();
  }
});

/***/ }),

/***/ "./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/admin/coordenador/FormCoordenador.vue?vue&type=style&index=0&id=0b3bffba&scoped=true&lang=css&":
/*!*************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/admin/coordenador/FormCoordenador.vue?vue&type=style&index=0&id=0b3bffba&scoped=true&lang=css& ***!
  \*************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_laravel_mix_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../../../../node_modules/laravel-mix/node_modules/css-loader/dist/runtime/api.js */ "./node_modules/laravel-mix/node_modules/css-loader/dist/runtime/api.js");
/* harmony import */ var _node_modules_laravel_mix_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_laravel_mix_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__);
// Imports

var ___CSS_LOADER_EXPORT___ = _node_modules_laravel_mix_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default()(function(i){return i[1]});
// Module
___CSS_LOADER_EXPORT___.push([module.id, "\n[data-v-0b3bffba] .modal-backdrop {\n    opacity: 0.5 !important;\n}\n", ""]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/admin/coordenador_nacional/FormCoordenador.vue?vue&type=style&index=0&id=b94c6d8c&scoped=true&lang=css&":
/*!**********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/admin/coordenador_nacional/FormCoordenador.vue?vue&type=style&index=0&id=b94c6d8c&scoped=true&lang=css& ***!
  \**********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_laravel_mix_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../../../../node_modules/laravel-mix/node_modules/css-loader/dist/runtime/api.js */ "./node_modules/laravel-mix/node_modules/css-loader/dist/runtime/api.js");
/* harmony import */ var _node_modules_laravel_mix_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_laravel_mix_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__);
// Imports

var ___CSS_LOADER_EXPORT___ = _node_modules_laravel_mix_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default()(function(i){return i[1]});
// Module
___CSS_LOADER_EXPORT___.push([module.id, "\n[data-v-b94c6d8c] .modal-backdrop {\n    opacity: 0.5 !important;\n}\n", ""]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/admin/usuario/FormUsuario.vue?vue&type=style&index=0&id=9e539d64&scoped=true&lang=css&":
/*!*****************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/admin/usuario/FormUsuario.vue?vue&type=style&index=0&id=9e539d64&scoped=true&lang=css& ***!
  \*****************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_laravel_mix_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../../../../node_modules/laravel-mix/node_modules/css-loader/dist/runtime/api.js */ "./node_modules/laravel-mix/node_modules/css-loader/dist/runtime/api.js");
/* harmony import */ var _node_modules_laravel_mix_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_laravel_mix_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__);
// Imports

var ___CSS_LOADER_EXPORT___ = _node_modules_laravel_mix_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default()(function(i){return i[1]});
// Module
___CSS_LOADER_EXPORT___.push([module.id, "\n[data-v-9e539d64] .modal-backdrop {\n    opacity: 0.5 !important;\n}\n", ""]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/style-loader/dist/cjs.js!./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/admin/coordenador/FormCoordenador.vue?vue&type=style&index=0&id=0b3bffba&scoped=true&lang=css&":
/*!*****************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader/dist/cjs.js!./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/admin/coordenador/FormCoordenador.vue?vue&type=style&index=0&id=0b3bffba&scoped=true&lang=css& ***!
  \*****************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../../../node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_laravel_mix_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_FormCoordenador_vue_vue_type_style_index_0_id_0b3bffba_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../../../../node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./FormCoordenador.vue?vue&type=style&index=0&id=0b3bffba&scoped=true&lang=css& */ "./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/admin/coordenador/FormCoordenador.vue?vue&type=style&index=0&id=0b3bffba&scoped=true&lang=css&");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_node_modules_laravel_mix_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_FormCoordenador_vue_vue_type_style_index_0_id_0b3bffba_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_1__["default"], options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_laravel_mix_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_FormCoordenador_vue_vue_type_style_index_0_id_0b3bffba_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_1__["default"].locals || {});

/***/ }),

/***/ "./node_modules/style-loader/dist/cjs.js!./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/admin/coordenador_nacional/FormCoordenador.vue?vue&type=style&index=0&id=b94c6d8c&scoped=true&lang=css&":
/*!**************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader/dist/cjs.js!./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/admin/coordenador_nacional/FormCoordenador.vue?vue&type=style&index=0&id=b94c6d8c&scoped=true&lang=css& ***!
  \**************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../../../node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_laravel_mix_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_FormCoordenador_vue_vue_type_style_index_0_id_b94c6d8c_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../../../../node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./FormCoordenador.vue?vue&type=style&index=0&id=b94c6d8c&scoped=true&lang=css& */ "./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/admin/coordenador_nacional/FormCoordenador.vue?vue&type=style&index=0&id=b94c6d8c&scoped=true&lang=css&");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_node_modules_laravel_mix_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_FormCoordenador_vue_vue_type_style_index_0_id_b94c6d8c_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_1__["default"], options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_laravel_mix_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_FormCoordenador_vue_vue_type_style_index_0_id_b94c6d8c_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_1__["default"].locals || {});

/***/ }),

/***/ "./node_modules/style-loader/dist/cjs.js!./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/admin/usuario/FormUsuario.vue?vue&type=style&index=0&id=9e539d64&scoped=true&lang=css&":
/*!*********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader/dist/cjs.js!./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/admin/usuario/FormUsuario.vue?vue&type=style&index=0&id=9e539d64&scoped=true&lang=css& ***!
  \*********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../../../node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_laravel_mix_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_FormUsuario_vue_vue_type_style_index_0_id_9e539d64_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../../../../node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./FormUsuario.vue?vue&type=style&index=0&id=9e539d64&scoped=true&lang=css& */ "./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/admin/usuario/FormUsuario.vue?vue&type=style&index=0&id=9e539d64&scoped=true&lang=css&");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_node_modules_laravel_mix_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_FormUsuario_vue_vue_type_style_index_0_id_9e539d64_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_1__["default"], options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_laravel_mix_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_FormUsuario_vue_vue_type_style_index_0_id_9e539d64_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_1__["default"].locals || {});

/***/ }),

/***/ "./resources/js/components/admin/coordenador/FormCoordenador.vue":
/*!***********************************************************************!*\
  !*** ./resources/js/components/admin/coordenador/FormCoordenador.vue ***!
  \***********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _FormCoordenador_vue_vue_type_template_id_0b3bffba_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./FormCoordenador.vue?vue&type=template&id=0b3bffba&scoped=true& */ "./resources/js/components/admin/coordenador/FormCoordenador.vue?vue&type=template&id=0b3bffba&scoped=true&");
/* harmony import */ var _FormCoordenador_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./FormCoordenador.vue?vue&type=script&lang=js& */ "./resources/js/components/admin/coordenador/FormCoordenador.vue?vue&type=script&lang=js&");
/* harmony import */ var _FormCoordenador_vue_vue_type_style_index_0_id_0b3bffba_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./FormCoordenador.vue?vue&type=style&index=0&id=0b3bffba&scoped=true&lang=css& */ "./resources/js/components/admin/coordenador/FormCoordenador.vue?vue&type=style&index=0&id=0b3bffba&scoped=true&lang=css&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");



;


/* normalize component */

var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__["default"])(
  _FormCoordenador_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _FormCoordenador_vue_vue_type_template_id_0b3bffba_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
  _FormCoordenador_vue_vue_type_template_id_0b3bffba_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  "0b3bffba",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/admin/coordenador/FormCoordenador.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/admin/coordenador_nacional/FormCoordenador.vue":
/*!********************************************************************************!*\
  !*** ./resources/js/components/admin/coordenador_nacional/FormCoordenador.vue ***!
  \********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _FormCoordenador_vue_vue_type_template_id_b94c6d8c_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./FormCoordenador.vue?vue&type=template&id=b94c6d8c&scoped=true& */ "./resources/js/components/admin/coordenador_nacional/FormCoordenador.vue?vue&type=template&id=b94c6d8c&scoped=true&");
/* harmony import */ var _FormCoordenador_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./FormCoordenador.vue?vue&type=script&lang=js& */ "./resources/js/components/admin/coordenador_nacional/FormCoordenador.vue?vue&type=script&lang=js&");
/* harmony import */ var _FormCoordenador_vue_vue_type_style_index_0_id_b94c6d8c_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./FormCoordenador.vue?vue&type=style&index=0&id=b94c6d8c&scoped=true&lang=css& */ "./resources/js/components/admin/coordenador_nacional/FormCoordenador.vue?vue&type=style&index=0&id=b94c6d8c&scoped=true&lang=css&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");



;


/* normalize component */

var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__["default"])(
  _FormCoordenador_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _FormCoordenador_vue_vue_type_template_id_b94c6d8c_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
  _FormCoordenador_vue_vue_type_template_id_b94c6d8c_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  "b94c6d8c",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/admin/coordenador_nacional/FormCoordenador.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/admin/usuario/FormUsuario.vue":
/*!***************************************************************!*\
  !*** ./resources/js/components/admin/usuario/FormUsuario.vue ***!
  \***************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _FormUsuario_vue_vue_type_template_id_9e539d64_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./FormUsuario.vue?vue&type=template&id=9e539d64&scoped=true& */ "./resources/js/components/admin/usuario/FormUsuario.vue?vue&type=template&id=9e539d64&scoped=true&");
/* harmony import */ var _FormUsuario_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./FormUsuario.vue?vue&type=script&lang=js& */ "./resources/js/components/admin/usuario/FormUsuario.vue?vue&type=script&lang=js&");
/* harmony import */ var _FormUsuario_vue_vue_type_style_index_0_id_9e539d64_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./FormUsuario.vue?vue&type=style&index=0&id=9e539d64&scoped=true&lang=css& */ "./resources/js/components/admin/usuario/FormUsuario.vue?vue&type=style&index=0&id=9e539d64&scoped=true&lang=css&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");



;


/* normalize component */

var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__["default"])(
  _FormUsuario_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _FormUsuario_vue_vue_type_template_id_9e539d64_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
  _FormUsuario_vue_vue_type_template_id_9e539d64_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  "9e539d64",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/admin/usuario/FormUsuario.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/admin/coordenador/FormCoordenador.vue?vue&type=script&lang=js&":
/*!************************************************************************************************!*\
  !*** ./resources/js/components/admin/coordenador/FormCoordenador.vue?vue&type=script&lang=js& ***!
  \************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_FormCoordenador_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./FormCoordenador.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/admin/coordenador/FormCoordenador.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_FormCoordenador_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/admin/coordenador_nacional/FormCoordenador.vue?vue&type=script&lang=js&":
/*!*********************************************************************************************************!*\
  !*** ./resources/js/components/admin/coordenador_nacional/FormCoordenador.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_FormCoordenador_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./FormCoordenador.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/admin/coordenador_nacional/FormCoordenador.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_FormCoordenador_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/admin/usuario/FormUsuario.vue?vue&type=script&lang=js&":
/*!****************************************************************************************!*\
  !*** ./resources/js/components/admin/usuario/FormUsuario.vue?vue&type=script&lang=js& ***!
  \****************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_FormUsuario_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./FormUsuario.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/admin/usuario/FormUsuario.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_FormUsuario_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/admin/coordenador/FormCoordenador.vue?vue&type=style&index=0&id=0b3bffba&scoped=true&lang=css&":
/*!********************************************************************************************************************************!*\
  !*** ./resources/js/components/admin/coordenador/FormCoordenador.vue?vue&type=style&index=0&id=0b3bffba&scoped=true&lang=css& ***!
  \********************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_dist_cjs_js_node_modules_laravel_mix_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_FormCoordenador_vue_vue_type_style_index_0_id_0b3bffba_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/style-loader/dist/cjs.js!../../../../../node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./FormCoordenador.vue?vue&type=style&index=0&id=0b3bffba&scoped=true&lang=css& */ "./node_modules/style-loader/dist/cjs.js!./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/admin/coordenador/FormCoordenador.vue?vue&type=style&index=0&id=0b3bffba&scoped=true&lang=css&");


/***/ }),

/***/ "./resources/js/components/admin/coordenador_nacional/FormCoordenador.vue?vue&type=style&index=0&id=b94c6d8c&scoped=true&lang=css&":
/*!*****************************************************************************************************************************************!*\
  !*** ./resources/js/components/admin/coordenador_nacional/FormCoordenador.vue?vue&type=style&index=0&id=b94c6d8c&scoped=true&lang=css& ***!
  \*****************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_dist_cjs_js_node_modules_laravel_mix_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_FormCoordenador_vue_vue_type_style_index_0_id_b94c6d8c_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/style-loader/dist/cjs.js!../../../../../node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./FormCoordenador.vue?vue&type=style&index=0&id=b94c6d8c&scoped=true&lang=css& */ "./node_modules/style-loader/dist/cjs.js!./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/admin/coordenador_nacional/FormCoordenador.vue?vue&type=style&index=0&id=b94c6d8c&scoped=true&lang=css&");


/***/ }),

/***/ "./resources/js/components/admin/usuario/FormUsuario.vue?vue&type=style&index=0&id=9e539d64&scoped=true&lang=css&":
/*!************************************************************************************************************************!*\
  !*** ./resources/js/components/admin/usuario/FormUsuario.vue?vue&type=style&index=0&id=9e539d64&scoped=true&lang=css& ***!
  \************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_dist_cjs_js_node_modules_laravel_mix_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_FormUsuario_vue_vue_type_style_index_0_id_9e539d64_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/style-loader/dist/cjs.js!../../../../../node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./FormUsuario.vue?vue&type=style&index=0&id=9e539d64&scoped=true&lang=css& */ "./node_modules/style-loader/dist/cjs.js!./node_modules/laravel-mix/node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/admin/usuario/FormUsuario.vue?vue&type=style&index=0&id=9e539d64&scoped=true&lang=css&");


/***/ }),

/***/ "./resources/js/components/admin/coordenador/FormCoordenador.vue?vue&type=template&id=0b3bffba&scoped=true&":
/*!******************************************************************************************************************!*\
  !*** ./resources/js/components/admin/coordenador/FormCoordenador.vue?vue&type=template&id=0b3bffba&scoped=true& ***!
  \******************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_FormCoordenador_vue_vue_type_template_id_0b3bffba_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   "staticRenderFns": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_FormCoordenador_vue_vue_type_template_id_0b3bffba_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_FormCoordenador_vue_vue_type_template_id_0b3bffba_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./FormCoordenador.vue?vue&type=template&id=0b3bffba&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/admin/coordenador/FormCoordenador.vue?vue&type=template&id=0b3bffba&scoped=true&");


/***/ }),

/***/ "./resources/js/components/admin/coordenador_nacional/FormCoordenador.vue?vue&type=template&id=b94c6d8c&scoped=true&":
/*!***************************************************************************************************************************!*\
  !*** ./resources/js/components/admin/coordenador_nacional/FormCoordenador.vue?vue&type=template&id=b94c6d8c&scoped=true& ***!
  \***************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_FormCoordenador_vue_vue_type_template_id_b94c6d8c_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   "staticRenderFns": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_FormCoordenador_vue_vue_type_template_id_b94c6d8c_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_FormCoordenador_vue_vue_type_template_id_b94c6d8c_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./FormCoordenador.vue?vue&type=template&id=b94c6d8c&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/admin/coordenador_nacional/FormCoordenador.vue?vue&type=template&id=b94c6d8c&scoped=true&");


/***/ }),

/***/ "./resources/js/components/admin/usuario/FormUsuario.vue?vue&type=template&id=9e539d64&scoped=true&":
/*!**********************************************************************************************************!*\
  !*** ./resources/js/components/admin/usuario/FormUsuario.vue?vue&type=template&id=9e539d64&scoped=true& ***!
  \**********************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_FormUsuario_vue_vue_type_template_id_9e539d64_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   "staticRenderFns": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_FormUsuario_vue_vue_type_template_id_9e539d64_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_FormUsuario_vue_vue_type_template_id_9e539d64_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./FormUsuario.vue?vue&type=template&id=9e539d64&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/admin/usuario/FormUsuario.vue?vue&type=template&id=9e539d64&scoped=true&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/admin/coordenador/FormCoordenador.vue?vue&type=template&id=0b3bffba&scoped=true&":
/*!*********************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/admin/coordenador/FormCoordenador.vue?vue&type=template&id=0b3bffba&scoped=true& ***!
  \*********************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* binding */ render),
/* harmony export */   "staticRenderFns": () => (/* binding */ staticRenderFns)
/* harmony export */ });
var render = function () {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "b-modal",
    {
      attrs: { id: "coordenadorModal", size: "lg", "no-close-on-backdrop": "" },
      scopedSlots: _vm._u([
        {
          key: "modal-header",
          fn: function (ref) {
            var close = ref.close
            return [
              _vm.post.id
                ? _c("h5", [_vm._v("Editar Coordenador")])
                : _c("h5", [_vm._v("Cadastrar Coordenador")]),
              _vm._v(" "),
              _c(
                "b-button",
                {
                  attrs: { size: "sm", variant: "outline-danger" },
                  on: {
                    click: function ($event) {
                      return close()
                    },
                  },
                },
                [_vm._v("x")]
              ),
            ]
          },
        },
        {
          key: "modal-footer",
          fn: function (ref) {
            var cancel = ref.cancel
            return [
              _c(
                "b-button",
                {
                  attrs: {
                    size: "md",
                    variant: "outline-danger",
                    disabled: _vm.loading,
                  },
                  on: {
                    click: function ($event) {
                      return cancel()
                    },
                  },
                },
                [_vm._v("\n                Cancelar\n            ")]
              ),
              _vm._v(" "),
              _c(
                "b-button",
                {
                  attrs: {
                    disabled: _vm.loading,
                    size: "md",
                    variant: "outline-success",
                  },
                  on: {
                    click: function ($event) {
                      return _vm.save()
                    },
                  },
                },
                [
                  _vm._v(
                    "\n                " +
                      _vm._s(_vm.post.id ? "Atualizar" : "Cadastrar") +
                      "\n            "
                  ),
                ]
              ),
            ]
          },
        },
      ]),
    },
    [
      _vm._v(" "),
      [
        _c(
          "b-row",
          [
            _c(
              "b-col",
              { attrs: { cols: "12", sm: "6", lg: "6" } },
              [
                _c(
                  "b-form-group",
                  {
                    attrs: { label: "Nome", "label-class": "font-weight-bold" },
                  },
                  [
                    _c("b-form-input", {
                      directives: [
                        {
                          name: "validate",
                          rawName: "v-validate",
                          value: { required: true, fullName: _vm.post.name },
                          expression: "{ required: true, fullName: post.name }",
                        },
                      ],
                      class: [
                        "form-control form-control-sm",
                        { "is-invalid": _vm.errors.has("name") },
                      ],
                      attrs: {
                        name: "name",
                        size: "sm",
                        type: "text",
                        disabled: _vm.loading,
                        "aria-describedby": "input-1-live-feedback",
                        "data-vv-as": "name",
                      },
                      model: {
                        value: _vm.post.name,
                        callback: function ($$v) {
                          _vm.$set(_vm.post, "name", $$v)
                        },
                        expression: "post.name",
                      },
                    }),
                    _vm._v(" "),
                    _c(
                      "span",
                      {
                        directives: [
                          {
                            name: "show",
                            rawName: "v-show",
                            value: _vm.errors.has("name"),
                            expression: "errors.has(`name`)",
                          },
                        ],
                        staticClass: "invalid-feedback",
                      },
                      [
                        _vm._v(
                          "\n                        " +
                            _vm._s(_vm.errors.first("name")) +
                            "\n                    "
                        ),
                      ]
                    ),
                  ],
                  1
                ),
              ],
              1
            ),
            _vm._v(" "),
            _c(
              "b-col",
              { attrs: { cols: "12", sm: "6", lg: "6" } },
              [
                _c(
                  "b-form-group",
                  {
                    attrs: { label: "Tipo", "label-class": "font-weight-bold" },
                  },
                  [
                    _c(
                      "b-form-select",
                      {
                        directives: [
                          {
                            name: "validate",
                            rawName: "v-validate",
                            value: { required: true },
                            expression: "{ required: true }",
                          },
                        ],
                        staticClass: "form-control form-control-sm",
                        class: [
                          "form-control form-control-sm",
                          { "is-invalid": _vm.errors.has("tipo") },
                        ],
                        attrs: {
                          disabled: _vm.loading,
                          name: "tipo",
                          size: "sm",
                          "data-vv-as": "Tipo",
                        },
                        model: {
                          value: _vm.post.tipo,
                          callback: function ($$v) {
                            _vm.$set(_vm.post, "tipo", $$v)
                          },
                          expression: "post.tipo",
                        },
                      },
                      [
                        _c("option", { domProps: { value: null } }, [
                          _vm._v("Selecione"),
                        ]),
                        _vm._v(" "),
                        _vm._l(_vm.tipos, function (tipo) {
                          return _c(
                            "option",
                            {
                              key: tipo.value,
                              domProps: { value: tipo.value },
                            },
                            [
                              _vm._v(
                                "\n                        " +
                                  _vm._s(tipo.text) +
                                  "\n                    "
                              ),
                            ]
                          )
                        }),
                      ],
                      2
                    ),
                    _vm._v(" "),
                    _c(
                      "span",
                      {
                        directives: [
                          {
                            name: "show",
                            rawName: "v-show",
                            value: _vm.errors.has("tipo"),
                            expression: "errors.has(`tipo`)",
                          },
                        ],
                        staticClass: "invalid-feedback d-block",
                      },
                      [
                        _vm._v(
                          "\n                        " +
                            _vm._s(_vm.errors.first("tipo")) +
                            "\n                    "
                        ),
                      ]
                    ),
                  ],
                  1
                ),
              ],
              1
            ),
            _vm._v(" "),
            _vm.tipo_expocom == false
              ? _c(
                  "b-col",
                  { attrs: { cols: "12", sm: "6", lg: "6" } },
                  [
                    _c(
                      "b-form-group",
                      {
                        attrs: {
                          label: "Regiao",
                          "label-class": "font-weight-bold",
                        },
                      },
                      [
                        _c(
                          "b-form-select",
                          {
                            directives: [
                              {
                                name: "validate",
                                rawName: "v-validate",
                                value: {
                                  required:
                                    _vm.tipo_expocom == true ? false : true,
                                },
                                expression:
                                  "{ required: tipo_expocom == true ? false : true }",
                              },
                            ],
                            class: [
                              "form-control form-control-sm",
                              { "is-invalid": _vm.errors.has("regiao") },
                            ],
                            attrs: {
                              disabled: _vm.loading,
                              name: "regiao",
                              size: "sm",
                              "data-vv-as": "Regiao",
                            },
                            model: {
                              value: _vm.post.regiao,
                              callback: function ($$v) {
                                _vm.$set(_vm.post, "regiao", $$v)
                              },
                              expression: "post.regiao",
                            },
                          },
                          [
                            _c("option", { domProps: { value: null } }, [
                              _vm._v("Selecione"),
                            ]),
                            _vm._v(" "),
                            _vm._l(_vm.regioes, function (regiao) {
                              return _c(
                                "option",
                                {
                                  key: regiao.value,
                                  domProps: { value: regiao.value },
                                },
                                [
                                  _vm._v(
                                    "\n                        " +
                                      _vm._s(regiao.text) +
                                      "\n                    "
                                  ),
                                ]
                              )
                            }),
                          ],
                          2
                        ),
                        _vm._v(" "),
                        _c(
                          "span",
                          {
                            directives: [
                              {
                                name: "show",
                                rawName: "v-show",
                                value: _vm.errors.has("regiao"),
                                expression: "errors.has(`regiao`)",
                              },
                            ],
                            staticClass: "invalid-feedback d-block",
                          },
                          [
                            _vm._v(
                              "\n                        " +
                                _vm._s(_vm.errors.first("regiao")) +
                                "\n                    "
                            ),
                          ]
                        ),
                      ],
                      1
                    ),
                  ],
                  1
                )
              : _vm._e(),
            _vm._v(" "),
            _c(
              "b-col",
              { attrs: { cols: "12", sm: "6", lg: "6" } },
              [
                _c(
                  "b-form-group",
                  {
                    attrs: { label: "Ano", "label-class": "font-weight-bold" },
                  },
                  [
                    _c("b-form-input", {
                      directives: [
                        {
                          name: "validate",
                          rawName: "v-validate",
                          value: { required: true },
                          expression: "{ required: true }",
                        },
                      ],
                      class: [
                        "form-control form-control-sm",
                        { "is-invalid": _vm.errors.has("ano") },
                      ],
                      attrs: {
                        name: "ano",
                        size: "sm",
                        type: "text",
                        disabled: _vm.loading,
                        "aria-describedby": "input-1-live-feedback",
                        "data-vv-as": "ano",
                      },
                      model: {
                        value: _vm.post.ano,
                        callback: function ($$v) {
                          _vm.$set(_vm.post, "ano", $$v)
                        },
                        expression: "post.ano",
                      },
                    }),
                    _vm._v(" "),
                    _c(
                      "span",
                      {
                        directives: [
                          {
                            name: "show",
                            rawName: "v-show",
                            value: _vm.errors.has("ano"),
                            expression: "errors.has(`ano`)",
                          },
                        ],
                        staticClass: "invalid-feedback",
                      },
                      [
                        _vm._v(
                          "\n                        " +
                            _vm._s(_vm.errors.first("ano")) +
                            "\n                    "
                        ),
                      ]
                    ),
                  ],
                  1
                ),
              ],
              1
            ),
            _vm._v(" "),
            _c(
              "b-col",
              { attrs: { cols: "12", sm: "6", lg: "4" } },
              [
                _c(
                  "b-form-group",
                  {
                    attrs: {
                      label: "Coordenador Geral",
                      "label-class": "font-weight-bold",
                    },
                  },
                  [
                    _c("b-form-radio-group", {
                      directives: [
                        {
                          name: "validate",
                          rawName: "v-validate",
                          value: {
                            required: _vm.post.geral == 0 ? true : false,
                          },
                          expression:
                            "{ required: post.geral == 0 ? true : false }",
                        },
                      ],
                      attrs: {
                        disabled: _vm.loading,
                        options: _vm.options,
                        "button-variant": "outline-primary",
                        size: "sm",
                        name: "geral",
                        buttons: "",
                      },
                      model: {
                        value: _vm.post.geral,
                        callback: function ($$v) {
                          _vm.$set(_vm.post, "geral", $$v)
                        },
                        expression: "post.geral",
                      },
                    }),
                    _vm._v(" "),
                    _c(
                      "span",
                      {
                        directives: [
                          {
                            name: "show",
                            rawName: "v-show",
                            value: _vm.errors.has("geral"),
                            expression: "errors.has(`geral`)",
                          },
                        ],
                        staticClass: "invalid-feedback d-block",
                      },
                      [
                        _vm._v(
                          "\n                        " +
                            _vm._s(_vm.errors.first("geral")) +
                            "\n                    "
                        ),
                      ]
                    ),
                  ],
                  1
                ),
              ],
              1
            ),
            _vm._v(" "),
            _vm.tipo_expocom == true
              ? _c(
                  "b-col",
                  { attrs: { cols: "12", sm: "12", lg: "12" } },
                  [
                    _c(
                      "b-form-group",
                      {
                        attrs: {
                          label: "DIVISÕES TEMÁTICAS:",
                          "label-class": "font-weight-bold",
                        },
                      },
                      [
                        _c(
                          "b-form-select",
                          {
                            directives: [
                              {
                                name: "validate",
                                rawName: "v-validate",
                                value: {
                                  required:
                                    _vm.tipo_expocom == true ? true : false,
                                },
                                expression:
                                  "{ required: tipo_expocom == true ? true : false }",
                              },
                            ],
                            class: [
                              "form-control form-control-sm",
                              {
                                "is-invalid":
                                  _vm.errors.has("divisoes_tematicas"),
                              },
                            ],
                            attrs: {
                              disabled: _vm.loading,
                              name: "divisoes_tematicas",
                              size: "sm",
                              "data-vv-as": "DIVISÕES TEMÁTICAS",
                            },
                            model: {
                              value: _vm.post.dt,
                              callback: function ($$v) {
                                _vm.$set(_vm.post, "dt", $$v)
                              },
                              expression: "post.dt",
                            },
                          },
                          [
                            _c("option", { domProps: { value: null } }, [
                              _vm._v("Selecione"),
                            ]),
                            _vm._v(" "),
                            _vm._l(
                              _vm.divisoes_tematicas,
                              function (divisoes_tematica) {
                                return _c(
                                  "option",
                                  {
                                    key: divisoes_tematica.value,
                                    domProps: {
                                      value: divisoes_tematica.value,
                                    },
                                  },
                                  [
                                    _vm._v(
                                      "\n                        " +
                                        _vm._s(divisoes_tematica.text) +
                                        "\n                    "
                                    ),
                                  ]
                                )
                              }
                            ),
                          ],
                          2
                        ),
                        _vm._v(" "),
                        _c(
                          "span",
                          {
                            directives: [
                              {
                                name: "show",
                                rawName: "v-show",
                                value: _vm.errors.has("divisoes_tematicas"),
                                expression: "errors.has(`divisoes_tematicas`)",
                              },
                            ],
                            staticClass: "invalid-feedback d-block",
                          },
                          [
                            _vm._v(
                              "\n                        " +
                                _vm._s(_vm.errors.first("divisoes_tematicas")) +
                                "\n                    "
                            ),
                          ]
                        ),
                      ],
                      1
                    ),
                  ],
                  1
                )
              : _vm._e(),
          ],
          1
        ),
      ],
    ],
    2
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/admin/coordenador_nacional/FormCoordenador.vue?vue&type=template&id=b94c6d8c&scoped=true&":
/*!******************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/admin/coordenador_nacional/FormCoordenador.vue?vue&type=template&id=b94c6d8c&scoped=true& ***!
  \******************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* binding */ render),
/* harmony export */   "staticRenderFns": () => (/* binding */ staticRenderFns)
/* harmony export */ });
var render = function () {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "b-modal",
    {
      attrs: { id: "coordenadorModal", size: "lg", "no-close-on-backdrop": "" },
      scopedSlots: _vm._u([
        {
          key: "modal-header",
          fn: function (ref) {
            var close = ref.close
            return [
              _vm.post.id
                ? _c("h5", [_vm._v("Editar Coordenador")])
                : _c("h5", [_vm._v("Cadastrar Coordenador")]),
              _vm._v(" "),
              _c(
                "b-button",
                {
                  attrs: { size: "sm", variant: "outline-danger" },
                  on: {
                    click: function ($event) {
                      return close()
                    },
                  },
                },
                [_vm._v("x")]
              ),
            ]
          },
        },
        {
          key: "modal-footer",
          fn: function (ref) {
            var cancel = ref.cancel
            return [
              _c(
                "b-button",
                {
                  attrs: {
                    size: "md",
                    variant: "outline-danger",
                    disabled: _vm.loading,
                  },
                  on: {
                    click: function ($event) {
                      return cancel()
                    },
                  },
                },
                [_vm._v("\n                Cancelar\n            ")]
              ),
              _vm._v(" "),
              _c(
                "b-button",
                {
                  attrs: {
                    disabled: _vm.loading,
                    size: "md",
                    variant: "outline-success",
                  },
                  on: {
                    click: function ($event) {
                      return _vm.save()
                    },
                  },
                },
                [
                  _vm._v(
                    "\n                " +
                      _vm._s(_vm.post.id ? "Atualizar" : "Cadastrar") +
                      "\n            "
                  ),
                ]
              ),
            ]
          },
        },
      ]),
    },
    [
      _vm._v(" "),
      [
        _c(
          "b-row",
          [
            _c(
              "b-col",
              { attrs: { cols: "12", sm: "6", lg: "6" } },
              [
                _c(
                  "b-form-group",
                  {
                    attrs: { label: "Nome", "label-class": "font-weight-bold" },
                  },
                  [
                    _c("b-form-input", {
                      directives: [
                        {
                          name: "validate",
                          rawName: "v-validate",
                          value: { required: true, fullName: _vm.post.name },
                          expression: "{ required: true, fullName: post.name }",
                        },
                      ],
                      class: [
                        "form-control form-control-sm",
                        { "is-invalid": _vm.errors.has("name") },
                      ],
                      attrs: {
                        name: "name",
                        size: "sm",
                        type: "text",
                        disabled: true,
                        "aria-describedby": "input-1-live-feedback",
                        "data-vv-as": "name",
                      },
                      model: {
                        value: _vm.post.name,
                        callback: function ($$v) {
                          _vm.$set(_vm.post, "name", $$v)
                        },
                        expression: "post.name",
                      },
                    }),
                    _vm._v(" "),
                    _c(
                      "span",
                      {
                        directives: [
                          {
                            name: "show",
                            rawName: "v-show",
                            value: _vm.errors.has("name"),
                            expression: "errors.has(`name`)",
                          },
                        ],
                        staticClass: "invalid-feedback",
                      },
                      [
                        _vm._v(
                          "\n                        " +
                            _vm._s(_vm.errors.first("name")) +
                            "\n                    "
                        ),
                      ]
                    ),
                  ],
                  1
                ),
              ],
              1
            ),
            _vm._v(" "),
            _c(
              "b-col",
              { attrs: { cols: "12", sm: "6", lg: "6" } },
              [
                _c(
                  "b-form-group",
                  {
                    attrs: { label: "Tipo", "label-class": "font-weight-bold" },
                  },
                  [
                    _c(
                      "b-form-select",
                      {
                        directives: [
                          {
                            name: "validate",
                            rawName: "v-validate",
                            value: { required: true },
                            expression: "{ required: true }",
                          },
                        ],
                        staticClass: "form-control form-control-sm",
                        class: [
                          "form-control form-control-sm",
                          { "is-invalid": _vm.errors.has("tipo") },
                        ],
                        attrs: {
                          disabled: _vm.loading,
                          name: "tipo",
                          size: "sm",
                          "data-vv-as": "Tipo",
                        },
                        model: {
                          value: _vm.post.tipo,
                          callback: function ($$v) {
                            _vm.$set(_vm.post, "tipo", $$v)
                          },
                          expression: "post.tipo",
                        },
                      },
                      [
                        _c("option", { domProps: { value: null } }, [
                          _vm._v("Selecione"),
                        ]),
                        _vm._v(" "),
                        _vm._l(_vm.tipos, function (tipo) {
                          return _c(
                            "option",
                            {
                              key: tipo.value,
                              domProps: { value: tipo.value },
                            },
                            [
                              _vm._v(
                                "\n                        " +
                                  _vm._s(tipo.text) +
                                  "\n                    "
                              ),
                            ]
                          )
                        }),
                      ],
                      2
                    ),
                    _vm._v(" "),
                    _c(
                      "span",
                      {
                        directives: [
                          {
                            name: "show",
                            rawName: "v-show",
                            value: _vm.errors.has("tipo"),
                            expression: "errors.has(`tipo`)",
                          },
                        ],
                        staticClass: "invalid-feedback d-block",
                      },
                      [
                        _vm._v(
                          "\n                        " +
                            _vm._s(_vm.errors.first("tipo")) +
                            "\n                    "
                        ),
                      ]
                    ),
                  ],
                  1
                ),
              ],
              1
            ),
            _vm._v(" "),
            _c(
              "b-col",
              { attrs: { cols: "12", sm: "6", lg: "6" } },
              [
                _c(
                  "b-form-group",
                  {
                    attrs: { label: "Ano", "label-class": "font-weight-bold" },
                  },
                  [
                    _c("b-form-input", {
                      directives: [
                        {
                          name: "validate",
                          rawName: "v-validate",
                          value: { required: true },
                          expression: "{ required: true }",
                        },
                      ],
                      class: [
                        "form-control form-control-sm",
                        { "is-invalid": _vm.errors.has("ano") },
                      ],
                      attrs: {
                        name: "ano",
                        size: "sm",
                        type: "text",
                        disabled: _vm.loading,
                        "aria-describedby": "input-1-live-feedback",
                        "data-vv-as": "ano",
                      },
                      model: {
                        value: _vm.post.ano,
                        callback: function ($$v) {
                          _vm.$set(_vm.post, "ano", $$v)
                        },
                        expression: "post.ano",
                      },
                    }),
                    _vm._v(" "),
                    _c(
                      "span",
                      {
                        directives: [
                          {
                            name: "show",
                            rawName: "v-show",
                            value: _vm.errors.has("ano"),
                            expression: "errors.has(`ano`)",
                          },
                        ],
                        staticClass: "invalid-feedback",
                      },
                      [
                        _vm._v(
                          "\n                        " +
                            _vm._s(_vm.errors.first("ano")) +
                            "\n                    "
                        ),
                      ]
                    ),
                  ],
                  1
                ),
              ],
              1
            ),
            _vm._v(" "),
            _c(
              "b-col",
              { attrs: { cols: "12", sm: "6", lg: "4" } },
              [
                _c(
                  "b-form-group",
                  {
                    attrs: {
                      label: "Coordenador Geral",
                      "label-class": "font-weight-bold",
                    },
                  },
                  [
                    _c("b-form-radio-group", {
                      directives: [
                        {
                          name: "validate",
                          rawName: "v-validate",
                          value: {
                            required: _vm.post.geral == 0 ? true : false,
                          },
                          expression:
                            "{ required: post.geral == 0 ? true : false }",
                        },
                      ],
                      attrs: {
                        disabled: _vm.loading,
                        options: _vm.options,
                        "button-variant": "outline-primary",
                        size: "sm",
                        name: "geral",
                        buttons: "",
                      },
                      model: {
                        value: _vm.post.geral,
                        callback: function ($$v) {
                          _vm.$set(_vm.post, "geral", $$v)
                        },
                        expression: "post.geral",
                      },
                    }),
                    _vm._v(" "),
                    _c(
                      "span",
                      {
                        directives: [
                          {
                            name: "show",
                            rawName: "v-show",
                            value: _vm.errors.has("geral"),
                            expression: "errors.has(`geral`)",
                          },
                        ],
                        staticClass: "invalid-feedback d-block",
                      },
                      [
                        _vm._v(
                          "\n                        " +
                            _vm._s(_vm.errors.first("geral")) +
                            "\n                    "
                        ),
                      ]
                    ),
                  ],
                  1
                ),
              ],
              1
            ),
            _vm._v(" "),
            _vm.post.tipo == 3
              ? _c(
                  "b-col",
                  { attrs: { cols: "12", sm: "12", lg: "12" } },
                  [
                    _c(
                      "b-form-group",
                      {
                        attrs: {
                          label: "DIVISÕES TEMÁTICAS:",
                          "label-class": "font-weight-bold",
                        },
                      },
                      [
                        _c(
                          "b-form-select",
                          {
                            directives: [
                              {
                                name: "validate",
                                rawName: "v-validate",
                                value: {
                                  required: _vm.post.tipo == 3 ? true : false,
                                },
                                expression:
                                  "{ required: post.tipo == 3 ? true : false }",
                              },
                            ],
                            class: [
                              "form-control form-control-sm",
                              {
                                "is-invalid":
                                  _vm.errors.has("divisoes_tematicas"),
                              },
                            ],
                            attrs: {
                              disabled: _vm.loading,
                              name: "divisoes_tematicas",
                              size: "sm",
                              "data-vv-as": "DIVISÕES TEMÁTICAS",
                            },
                            model: {
                              value: _vm.post.dt,
                              callback: function ($$v) {
                                _vm.$set(_vm.post, "dt", $$v)
                              },
                              expression: "post.dt",
                            },
                          },
                          [
                            _c("option", { domProps: { value: null } }, [
                              _vm._v("Selecione"),
                            ]),
                            _vm._v(" "),
                            _vm._l(
                              _vm.divisoes_tematicas,
                              function (divisoes_tematica) {
                                return _c(
                                  "option",
                                  {
                                    key: divisoes_tematica.id,
                                    domProps: { value: divisoes_tematica.id },
                                  },
                                  [
                                    _vm._v(
                                      "\n                        " +
                                        _vm._s(divisoes_tematica.descricao) +
                                        "\n                    "
                                    ),
                                  ]
                                )
                              }
                            ),
                          ],
                          2
                        ),
                        _vm._v(" "),
                        _c(
                          "span",
                          {
                            directives: [
                              {
                                name: "show",
                                rawName: "v-show",
                                value: _vm.errors.has("divisoes_tematicas"),
                                expression: "errors.has(`divisoes_tematicas`)",
                              },
                            ],
                            staticClass: "invalid-feedback d-block",
                          },
                          [
                            _vm._v(
                              "\n                        " +
                                _vm._s(_vm.errors.first("divisoes_tematicas")) +
                                "\n                    "
                            ),
                          ]
                        ),
                      ],
                      1
                    ),
                  ],
                  1
                )
              : _vm._e(),
            _vm._v(" "),
            _vm.post.tipo == 2
              ? _c(
                  "b-col",
                  { attrs: { cols: "12", sm: "12", lg: "12" } },
                  [
                    _c(
                      "b-form-group",
                      {
                        attrs: {
                          label: "INTERCOM JÚNIOR:",
                          "label-class": "font-weight-bold",
                        },
                      },
                      [
                        _c(
                          "b-form-select",
                          {
                            directives: [
                              {
                                name: "validate",
                                rawName: "v-validate",
                                value: {
                                  required: _vm.post.tipo == 2 ? true : false,
                                },
                                expression:
                                  "{ required: post.tipo == 2 ? true : false }",
                              },
                            ],
                            class: [
                              "form-control form-control-sm",
                              {
                                "is-invalid": _vm.errors.has(
                                  "divisoes_tematicas_jr"
                                ),
                              },
                            ],
                            attrs: {
                              disabled: _vm.loading,
                              name: "divisoes_tematicas_jr",
                              size: "sm",
                              "data-vv-as": "DIVISÕES TEMÁTICAS",
                            },
                            model: {
                              value: _vm.post.ij,
                              callback: function ($$v) {
                                _vm.$set(_vm.post, "ij", $$v)
                              },
                              expression: "post.ij",
                            },
                          },
                          [
                            _c("option", { domProps: { value: null } }, [
                              _vm._v("Selecione"),
                            ]),
                            _vm._v(" "),
                            _vm._l(
                              _vm.divisoes_tematicas_jr,
                              function (divisoes_tematica_jr) {
                                return _c(
                                  "option",
                                  {
                                    key: divisoes_tematica_jr.id,
                                    domProps: {
                                      value: divisoes_tematica_jr.id,
                                    },
                                  },
                                  [
                                    _vm._v(
                                      "\n                        " +
                                        _vm._s(divisoes_tematica_jr.descricao) +
                                        "\n                    "
                                    ),
                                  ]
                                )
                              }
                            ),
                          ],
                          2
                        ),
                        _vm._v(" "),
                        _c(
                          "span",
                          {
                            directives: [
                              {
                                name: "show",
                                rawName: "v-show",
                                value: _vm.errors.has("divisoes_tematicas_jr"),
                                expression:
                                  "errors.has(`divisoes_tematicas_jr`)",
                              },
                            ],
                            staticClass: "invalid-feedback d-block",
                          },
                          [
                            _vm._v(
                              "\n                        " +
                                _vm._s(
                                  _vm.errors.first("divisoes_tematicas_jr")
                                ) +
                                "\n                    "
                            ),
                          ]
                        ),
                      ],
                      1
                    ),
                  ],
                  1
                )
              : _vm._e(),
            _vm._v(" "),
            _vm.post.tipo == 1
              ? _c(
                  "b-col",
                  { attrs: { cols: "12", sm: "12", lg: "12" } },
                  [
                    _c(
                      "b-form-group",
                      {
                        attrs: {
                          label: "GPs:",
                          "label-class": "font-weight-bold",
                        },
                      },
                      [
                        _c(
                          "b-form-select",
                          {
                            directives: [
                              {
                                name: "validate",
                                rawName: "v-validate",
                                value: {
                                  required: _vm.post.tipo == 2 ? true : false,
                                },
                                expression:
                                  "{ required: post.tipo == 2 ? true : false }",
                              },
                            ],
                            class: [
                              "form-control form-control-sm",
                              { "is-invalid": _vm.errors.has("gps") },
                            ],
                            attrs: {
                              disabled: _vm.loading,
                              name: "gps",
                              size: "sm",
                              "data-vv-as": "DIVISÕES TEMÁTICAS",
                            },
                            model: {
                              value: _vm.post.gps,
                              callback: function ($$v) {
                                _vm.$set(_vm.post, "gps", $$v)
                              },
                              expression: "post.gps",
                            },
                          },
                          [
                            _c("option", { domProps: { value: null } }, [
                              _vm._v("Selecione"),
                            ]),
                            _vm._v(" "),
                            _vm._l(_vm.gps, function (gp) {
                              return _c(
                                "option",
                                { key: gp.id, domProps: { value: gp.id } },
                                [
                                  _vm._v(
                                    "\n                        " +
                                      _vm._s(gp.descricao) +
                                      "\n                    "
                                  ),
                                ]
                              )
                            }),
                          ],
                          2
                        ),
                        _vm._v(" "),
                        _c(
                          "span",
                          {
                            directives: [
                              {
                                name: "show",
                                rawName: "v-show",
                                value: _vm.errors.has("gps"),
                                expression: "errors.has(`gps`)",
                              },
                            ],
                            staticClass: "invalid-feedback d-block",
                          },
                          [
                            _vm._v(
                              "\n                        " +
                                _vm._s(_vm.errors.first("gps")) +
                                "\n                    "
                            ),
                          ]
                        ),
                      ],
                      1
                    ),
                  ],
                  1
                )
              : _vm._e(),
          ],
          1
        ),
      ],
    ],
    2
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/admin/usuario/FormUsuario.vue?vue&type=template&id=9e539d64&scoped=true&":
/*!*************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/admin/usuario/FormUsuario.vue?vue&type=template&id=9e539d64&scoped=true& ***!
  \*************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* binding */ render),
/* harmony export */   "staticRenderFns": () => (/* binding */ staticRenderFns)
/* harmony export */ });
var render = function () {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "b-modal",
    {
      attrs: { id: "usuarioModal", size: "lg", "no-close-on-backdrop": "" },
      scopedSlots: _vm._u([
        {
          key: "modal-header",
          fn: function (ref) {
            var close = ref.close
            return [
              _vm.post.id
                ? _c("h5", [_vm._v("Editar Usuário")])
                : _c("h5", [_vm._v("Cadastrar Usuário")]),
              _vm._v(" "),
              _c(
                "b-button",
                {
                  attrs: { size: "sm", variant: "outline-danger" },
                  on: {
                    click: function ($event) {
                      return close()
                    },
                  },
                },
                [_vm._v("x")]
              ),
            ]
          },
        },
        {
          key: "modal-footer",
          fn: function (ref) {
            var cancel = ref.cancel
            return [
              _c(
                "b-button",
                {
                  attrs: {
                    size: "md",
                    variant: "outline-danger",
                    disabled: _vm.loading,
                  },
                  on: {
                    click: function ($event) {
                      return cancel()
                    },
                  },
                },
                [_vm._v("\n                Cancelar\n            ")]
              ),
              _vm._v(" "),
              _c(
                "b-button",
                {
                  attrs: {
                    disabled: _vm.loading,
                    size: "md",
                    variant: "outline-success",
                  },
                  on: {
                    click: function ($event) {
                      return _vm.save()
                    },
                  },
                },
                [
                  _vm._v(
                    "\n                " +
                      _vm._s(_vm.post.id ? "Atualizar" : "Cadastrar") +
                      "\n            "
                  ),
                ]
              ),
            ]
          },
        },
      ]),
    },
    [
      _vm._v(" "),
      [
        _c(
          "b-row",
          [
            _c(
              "b-col",
              { attrs: { cols: "12", sm: "6", lg: "4" } },
              [
                _c(
                  "b-form-group",
                  {
                    attrs: { label: "Nome", "label-class": "font-weight-bold" },
                  },
                  [
                    _c("b-form-input", {
                      directives: [
                        {
                          name: "validate",
                          rawName: "v-validate",
                          value: { fullName: _vm.post.name },
                          expression: "{ fullName: post.name }",
                        },
                      ],
                      class: [
                        "form-control form-control-sm",
                        { "is-invalid": _vm.errors.has("name") },
                      ],
                      attrs: {
                        name: "name",
                        size: "sm",
                        type: "text",
                        disabled: _vm.loading,
                        "aria-describedby": "input-1-live-feedback",
                        "data-vv-as": "name",
                      },
                      model: {
                        value: _vm.post.name,
                        callback: function ($$v) {
                          _vm.$set(_vm.post, "name", $$v)
                        },
                        expression: "post.name",
                      },
                    }),
                    _vm._v(" "),
                    _c(
                      "span",
                      {
                        directives: [
                          {
                            name: "show",
                            rawName: "v-show",
                            value: _vm.errors.has("name"),
                            expression: "errors.has(`name`)",
                          },
                        ],
                        staticClass: "invalid-feedback",
                      },
                      [
                        _vm._v(
                          "\n                        " +
                            _vm._s(_vm.errors.first("name")) +
                            "\n                    "
                        ),
                      ]
                    ),
                  ],
                  1
                ),
              ],
              1
            ),
            _vm._v(" "),
            _c(
              "b-col",
              [
                _c(
                  "b-form-group",
                  {
                    attrs: {
                      label: "E-mail",
                      "label-class": "font-weight-bold",
                      cols: "12",
                      sm: "6",
                      lg: "4",
                    },
                  },
                  [
                    _c("b-form-input", {
                      directives: [
                        {
                          name: "validate",
                          rawName: "v-validate",
                          value: { email: true },
                          expression: "{ email: true }",
                        },
                      ],
                      class: [
                        "form-control form-control-sm",
                        { "is-invalid": _vm.errors.has("email") },
                      ],
                      attrs: {
                        name: "email",
                        size: "sm",
                        type: "text",
                        disabled: _vm.loading,
                        "aria-describedby": "input-1-live-feedback",
                        "data-vv-as": "E-mail",
                      },
                      model: {
                        value: _vm.post.email,
                        callback: function ($$v) {
                          _vm.$set(_vm.post, "email", $$v)
                        },
                        expression: "post.email",
                      },
                    }),
                    _vm._v(" "),
                    _c(
                      "span",
                      {
                        directives: [
                          {
                            name: "show",
                            rawName: "v-show",
                            value: _vm.errors.has("email"),
                            expression: "errors.has(`email`)",
                          },
                        ],
                        staticClass: "invalid-feedback",
                      },
                      [
                        _vm._v(
                          "\n                        " +
                            _vm._s(_vm.errors.first("email")) +
                            "\n                    "
                        ),
                      ]
                    ),
                  ],
                  1
                ),
              ],
              1
            ),
            _vm._v(" "),
            _c(
              "b-col",
              { attrs: { cols: "12", sm: "6", lg: "4" } },
              [
                _c(
                  "b-form-group",
                  {
                    attrs: {
                      label: "Senha",
                      "label-class": "font-weight-bold",
                    },
                  },
                  [
                    _c("b-form-input", {
                      directives: [
                        {
                          name: "validate",
                          rawName: "v-validate",
                          value: { required: _vm.passRequired, min: 6 },
                          expression: "{ required: passRequired, min:6}",
                        },
                      ],
                      class: [
                        "form-control form-control-sm",
                        { "is-invalid": _vm.errors.has("password") },
                      ],
                      attrs: {
                        name: "password",
                        size: "sm",
                        disabled: _vm.loading,
                        type: _vm.showPassaword,
                        "aria-describedby": "input-1-live-feedback",
                        "data-vv-as": "Senha",
                      },
                      model: {
                        value: _vm.post.password,
                        callback: function ($$v) {
                          _vm.$set(_vm.post, "password", $$v)
                        },
                        expression: "post.password",
                      },
                    }),
                    _vm._v(" "),
                    _c(
                      "span",
                      {
                        directives: [
                          {
                            name: "show",
                            rawName: "v-show",
                            value: _vm.errors.has("password"),
                            expression: "errors.has(`password`)",
                          },
                        ],
                        staticClass: "invalid-feedback",
                      },
                      [
                        _vm._v(
                          "\n                        " +
                            _vm._s(_vm.errors.first("password")) +
                            "\n                    "
                        ),
                      ]
                    ),
                  ],
                  1
                ),
                _vm._v(" "),
                _c(
                  "b-form-checkbox",
                  {
                    attrs: { name: "check-button", switch: "" },
                    model: {
                      value: _vm.showHidePasswod,
                      callback: function ($$v) {
                        _vm.showHidePasswod = $$v
                      },
                      expression: "showHidePasswod",
                    },
                  },
                  [
                    _vm.showHidePasswod
                      ? _c("b", [_vm._v("Ocultar senha")])
                      : _vm._e(),
                    _vm._v(" "),
                    !_vm.showHidePasswod
                      ? _c("b", [_vm._v("Exibir senha")])
                      : _vm._e(),
                  ]
                ),
              ],
              1
            ),
            _vm._v(" "),
            _c(
              "b-col",
              { attrs: { cols: "12", sm: "6", lg: "4" } },
              [
                _c(
                  "b-form-group",
                  {
                    attrs: {
                      label: "Data de nascimento",
                      "label-class": "font-weight-bold",
                    },
                  },
                  [
                    _c("b-form-input", {
                      class: [
                        "form-control form-control-sm",
                        { "is-invalid": _vm.errors.has("data_nascimento") },
                      ],
                      attrs: {
                        name: "data_nascimento",
                        size: "sm",
                        type: "date",
                        disabled: _vm.loading,
                        "aria-describedby": "input-1-live-feedback",
                        "data-vv-as": "Data de nascimento",
                      },
                      model: {
                        value: _vm.post.data_nascimento,
                        callback: function ($$v) {
                          _vm.$set(_vm.post, "data_nascimento", $$v)
                        },
                        expression: "post.data_nascimento",
                      },
                    }),
                    _vm._v(" "),
                    _c(
                      "span",
                      {
                        directives: [
                          {
                            name: "show",
                            rawName: "v-show",
                            value: _vm.errors.has("data_nascimento"),
                            expression: "errors.has(`data_nascimento`)",
                          },
                        ],
                        staticClass: "invalid-feedback",
                      },
                      [
                        _vm._v(
                          "\n                        " +
                            _vm._s(_vm.errors.first("data_nascimento")) +
                            "\n                    "
                        ),
                      ]
                    ),
                  ],
                  1
                ),
              ],
              1
            ),
            _vm._v(" "),
            _c(
              "b-col",
              { attrs: { cols: "12", sm: "6", lg: "4" } },
              [
                _c(
                  "b-form-group",
                  {
                    attrs: {
                      label: "Estrangeiro",
                      "label-class": "font-weight-bold",
                    },
                  },
                  [
                    _c("b-form-radio-group", {
                      directives: [
                        {
                          name: "validate",
                          rawName: "v-validate",
                          value: {
                            required: _vm.post.estrangeiro == 0 ? true : false,
                          },
                          expression:
                            "{ required: post.estrangeiro == 0 ? true : false }",
                        },
                      ],
                      attrs: {
                        disabled: _vm.loading,
                        options: _vm.options,
                        "button-variant": "outline-primary",
                        size: "sm",
                        name: "estrangeiro",
                        buttons: "",
                      },
                      model: {
                        value: _vm.post.estrangeiro,
                        callback: function ($$v) {
                          _vm.$set(_vm.post, "estrangeiro", $$v)
                        },
                        expression: "post.estrangeiro",
                      },
                    }),
                    _vm._v(" "),
                    _c(
                      "span",
                      {
                        directives: [
                          {
                            name: "show",
                            rawName: "v-show",
                            value: _vm.errors.has("estrangeiro"),
                            expression: "errors.has(`estrangeiro`)",
                          },
                        ],
                        staticClass: "invalid-feedback d-block",
                      },
                      [
                        _vm._v(
                          "\n                        " +
                            _vm._s(_vm.errors.first("estrangeiro")) +
                            "\n                    "
                        ),
                      ]
                    ),
                  ],
                  1
                ),
              ],
              1
            ),
            _vm._v(" "),
            _vm.post.estrangeiro
              ? _c(
                  "b-col",
                  { attrs: { cols: "12", sm: "6", lg: "4" } },
                  [
                    _c(
                      "b-form-group",
                      {
                        attrs: {
                          label: "Passaporte",
                          "label-class": "font-weight-bold",
                        },
                      },
                      [
                        _c("b-form-input", {
                          directives: [
                            {
                              name: "mask",
                              rawName: "v-mask",
                              value: "########",
                              expression: "'########'",
                            },
                          ],
                          class: [
                            "form-control form-control-sm",
                            { "is-invalid": _vm.errors.has("passaporte") },
                          ],
                          attrs: {
                            name: "passaporte",
                            size: "sm",
                            disabled: _vm.loading,
                            type: "text",
                            "aria-describedby": "input-1-live-feedback",
                            "data-vv-as": "Passaporte",
                          },
                          model: {
                            value: _vm.post.passaporte,
                            callback: function ($$v) {
                              _vm.$set(_vm.post, "passaporte", $$v)
                            },
                            expression: "post.passaporte",
                          },
                        }),
                        _vm._v(" "),
                        _c(
                          "span",
                          {
                            directives: [
                              {
                                name: "show",
                                rawName: "v-show",
                                value: _vm.errors.has("passaporte"),
                                expression: "errors.has(`passaporte`)",
                              },
                            ],
                            staticClass: "invalid-feedback",
                          },
                          [
                            _vm._v(
                              "\n                        " +
                                _vm._s(_vm.errors.first("passaporte")) +
                                "\n                    "
                            ),
                          ]
                        ),
                      ],
                      1
                    ),
                  ],
                  1
                )
              : _vm._e(),
            _vm._v(" "),
            !_vm.post.estrangeiro
              ? _c(
                  "b-col",
                  { attrs: { cols: "12", sm: "6", lg: "4" } },
                  [
                    _c(
                      "b-form-group",
                      {
                        attrs: {
                          label: "CPF",
                          "label-class": "font-weight-bold",
                        },
                      },
                      [
                        _c("b-form-input", {
                          directives: [
                            {
                              name: "mask",
                              rawName: "v-mask",
                              value: "###.###.###-##",
                              expression: "'###.###.###-##'",
                            },
                          ],
                          class: [
                            "form-control form-control-sm",
                            { "is-invalid": _vm.errors.has("cpf") },
                          ],
                          attrs: {
                            name: "cpf",
                            size: "sm",
                            disabled: true,
                            type: "text",
                            "aria-describedby": "input-1-live-feedback",
                            "data-vv-as": "CPF",
                          },
                          model: {
                            value: _vm.post.cpf,
                            callback: function ($$v) {
                              _vm.$set(_vm.post, "cpf", $$v)
                            },
                            expression: "post.cpf",
                          },
                        }),
                        _vm._v(" "),
                        _c(
                          "span",
                          {
                            directives: [
                              {
                                name: "show",
                                rawName: "v-show",
                                value: _vm.errors.has("cpf"),
                                expression: "errors.has(`cpf`)",
                              },
                            ],
                            staticClass: "invalid-feedback",
                          },
                          [
                            _vm._v(
                              "\n                        " +
                                _vm._s(_vm.errors.first("cpf")) +
                                "\n                    "
                            ),
                          ]
                        ),
                      ],
                      1
                    ),
                  ],
                  1
                )
              : _vm._e(),
            _vm._v(" "),
            !_vm.post.estrangeiro
              ? _c(
                  "b-col",
                  { attrs: { cols: "12", sm: "6", lg: "4" } },
                  [
                    _c(
                      "b-form-group",
                      {
                        attrs: {
                          label: "RG",
                          "label-class": "font-weight-bold",
                        },
                      },
                      [
                        _c("b-form-input", {
                          class: [
                            "form-control form-control-sm",
                            { "is-invalid": _vm.errors.has("rg") },
                          ],
                          attrs: {
                            name: "rg",
                            size: "sm",
                            disabled: _vm.loading,
                            type: "text",
                            "aria-describedby": "input-1-live-feedback",
                            "data-vv-as": "RG",
                          },
                          model: {
                            value: _vm.post.rg,
                            callback: function ($$v) {
                              _vm.$set(_vm.post, "rg", $$v)
                            },
                            expression: "post.rg",
                          },
                        }),
                        _vm._v(" "),
                        _c(
                          "span",
                          {
                            directives: [
                              {
                                name: "show",
                                rawName: "v-show",
                                value: _vm.errors.has("rg"),
                                expression: "errors.has(`rg`)",
                              },
                            ],
                            staticClass: "invalid-feedback",
                          },
                          [
                            _vm._v(
                              "\n                        " +
                                _vm._s(_vm.errors.first("rg")) +
                                "\n                    "
                            ),
                          ]
                        ),
                      ],
                      1
                    ),
                  ],
                  1
                )
              : _vm._e(),
            _vm._v(" "),
            !_vm.post.estrangeiro
              ? _c(
                  "b-col",
                  { attrs: { cols: "12", sm: "6", lg: "4" } },
                  [
                    _c(
                      "b-form-group",
                      {
                        attrs: {
                          label: "Orgão expedidor",
                          "label-class": "font-weight-bold",
                        },
                      },
                      [
                        _c("b-form-input", {
                          class: [
                            "form-control form-control-sm",
                            { "is-invalid": _vm.errors.has("orgao_expedidor") },
                          ],
                          attrs: {
                            name: "orgao_expedidor",
                            size: "sm",
                            disabled: _vm.loading,
                            type: "text",
                            "aria-describedby": "input-1-live-feedback",
                            "data-vv-as": "Orgão expedidor",
                          },
                          model: {
                            value: _vm.post.orgao_expedidor,
                            callback: function ($$v) {
                              _vm.$set(_vm.post, "orgao_expedidor", $$v)
                            },
                            expression: "post.orgao_expedidor",
                          },
                        }),
                        _vm._v(" "),
                        _c(
                          "span",
                          {
                            directives: [
                              {
                                name: "show",
                                rawName: "v-show",
                                value: _vm.errors.has("orgao_expedidor"),
                                expression: "errors.has(`orgao_expedidor`)",
                              },
                            ],
                            staticClass: "invalid-feedback",
                          },
                          [
                            _vm._v(
                              "\n                        " +
                                _vm._s(_vm.errors.first("orgao_expedidor")) +
                                "\n                    "
                            ),
                          ]
                        ),
                      ],
                      1
                    ),
                  ],
                  1
                )
              : _vm._e(),
            _vm._v(" "),
            _c(
              "b-col",
              { attrs: { cols: "12", sm: "6", lg: "4" } },
              [
                _c(
                  "b-form-group",
                  {
                    attrs: {
                      label: "Telefone",
                      "label-class": "font-weight-bold",
                    },
                  },
                  [
                    _c("b-form-input", {
                      directives: [
                        {
                          name: "mask",
                          rawName: "v-mask",
                          value: ["(##) ####-####"],
                          expression: "['(##) ####-####']",
                        },
                      ],
                      class: [
                        "form-control form-control-sm",
                        { "is-invalid": _vm.errors.has("telefone") },
                      ],
                      attrs: {
                        name: "telefone",
                        size: "sm",
                        disabled: _vm.loading,
                        type: "text",
                        "aria-describedby": "input-1-live-feedback",
                        "data-vv-as": "CNPJ/CPF",
                      },
                      model: {
                        value: _vm.post.telefone,
                        callback: function ($$v) {
                          _vm.$set(_vm.post, "telefone", $$v)
                        },
                        expression: "post.telefone",
                      },
                    }),
                    _vm._v(" "),
                    _c(
                      "span",
                      {
                        directives: [
                          {
                            name: "show",
                            rawName: "v-show",
                            value: _vm.errors.has("telefone"),
                            expression: "errors.has(`telefone`)",
                          },
                        ],
                        staticClass: "invalid-feedback",
                      },
                      [
                        _vm._v(
                          "\n                        " +
                            _vm._s(_vm.errors.first("telefone")) +
                            "\n                    "
                        ),
                      ]
                    ),
                  ],
                  1
                ),
              ],
              1
            ),
            _vm._v(" "),
            _c(
              "b-col",
              { attrs: { cols: "12", sm: "6", lg: "4" } },
              [
                _c(
                  "b-form-group",
                  {
                    attrs: {
                      label: "Celular",
                      "label-class": "font-weight-bold",
                    },
                  },
                  [
                    _c("b-form-input", {
                      directives: [
                        {
                          name: "mask",
                          rawName: "v-mask",
                          value: ["(##) #####-####"],
                          expression: "['(##) #####-####']",
                        },
                      ],
                      class: [
                        "form-control form-control-sm",
                        { "is-invalid": _vm.errors.has("celular") },
                      ],
                      attrs: {
                        name: "celular",
                        size: "sm",
                        disabled: _vm.loading,
                        type: "text",
                        "aria-describedby": "input-1-live-feedback",
                        "data-vv-as": "Celular",
                      },
                      model: {
                        value: _vm.post.celular,
                        callback: function ($$v) {
                          _vm.$set(_vm.post, "celular", $$v)
                        },
                        expression: "post.celular",
                      },
                    }),
                    _vm._v(" "),
                    _c(
                      "span",
                      {
                        directives: [
                          {
                            name: "show",
                            rawName: "v-show",
                            value: _vm.errors.has("celular"),
                            expression: "errors.has(`celular`)",
                          },
                        ],
                        staticClass: "invalid-feedback",
                      },
                      [
                        _vm._v(
                          "\n                        " +
                            _vm._s(_vm.errors.first("celular")) +
                            "\n                    "
                        ),
                      ]
                    ),
                  ],
                  1
                ),
              ],
              1
            ),
            _vm._v(" "),
            _c(
              "b-col",
              { attrs: { cols: "12", sm: "6", lg: "4" } },
              [
                _c(
                  "b-form-group",
                  {
                    attrs: {
                      label: "Gênero",
                      "label-class": "font-weight-bold",
                    },
                  },
                  [
                    _c(
                      "b-form-select",
                      {
                        staticClass: "form-control form-control-sm",
                        class: [
                          "form-control form-control-sm",
                          { "is-invalid": _vm.errors.has("generos") },
                        ],
                        attrs: {
                          disabled: _vm.loading,
                          name: "generos",
                          size: "sm",
                          "data-vv-as": "Gênero",
                        },
                        model: {
                          value: _vm.post.sexo_id,
                          callback: function ($$v) {
                            _vm.$set(_vm.post, "sexo_id", $$v)
                          },
                          expression: "post.sexo_id",
                        },
                      },
                      [
                        _c("option", { domProps: { value: null } }, [
                          _vm._v("Selecione"),
                        ]),
                        _vm._v(" "),
                        _vm._l(_vm.generos, function (genero) {
                          return _c(
                            "option",
                            { key: genero.id, domProps: { value: genero.id } },
                            [
                              _vm._v(
                                "\n                        " +
                                  _vm._s(genero.tipo_sexo) +
                                  "\n                    "
                              ),
                            ]
                          )
                        }),
                      ],
                      2
                    ),
                    _vm._v(" "),
                    _c(
                      "span",
                      {
                        directives: [
                          {
                            name: "show",
                            rawName: "v-show",
                            value: _vm.errors.has("generos"),
                            expression: "errors.has(`generos`)",
                          },
                        ],
                        staticClass: "invalid-feedback",
                      },
                      [
                        _vm._v(
                          "\n                        " +
                            _vm._s(_vm.errors.first("generos")) +
                            "\n                    "
                        ),
                      ]
                    ),
                  ],
                  1
                ),
              ],
              1
            ),
            _vm._v(" "),
            _c(
              "b-col",
              { attrs: { cols: "12", sm: "6", lg: "4" } },
              [
                _c(
                  "b-form-group",
                  {
                    attrs: {
                      label: "Acesso ao sistema",
                      "label-class": "font-weight-bold",
                    },
                  },
                  [
                    _c("b-form-radio-group", {
                      directives: [
                        {
                          name: "validate",
                          rawName: "v-validate",
                          value: {
                            required: _vm.post.ativo == 0 ? true : false,
                          },
                          expression:
                            "{ required: post.ativo == 0 ? true : false }",
                        },
                      ],
                      attrs: {
                        disabled: _vm.loading,
                        options: _vm.options,
                        "button-variant": "outline-primary",
                        size: "sm",
                        name: "ativo",
                        buttons: "",
                      },
                      model: {
                        value: _vm.post.ativo,
                        callback: function ($$v) {
                          _vm.$set(_vm.post, "ativo", $$v)
                        },
                        expression: "post.ativo",
                      },
                    }),
                    _vm._v(" "),
                    _c(
                      "span",
                      {
                        directives: [
                          {
                            name: "show",
                            rawName: "v-show",
                            value: _vm.errors.has("ativo"),
                            expression: "errors.has(`ativo`)",
                          },
                        ],
                        staticClass: "invalid-feedback d-block",
                      },
                      [
                        _vm._v(
                          "\n                        " +
                            _vm._s(_vm.errors.first("ativo")) +
                            "\n                    "
                        ),
                      ]
                    ),
                  ],
                  1
                ),
              ],
              1
            ),
          ],
          1
        ),
        _vm._v(" "),
        _c("hr"),
        _vm._v(" "),
        _c(
          "b-row",
          [
            _c(
              "b-col",
              { attrs: { cols: "12", sm: "6", lg: "6" } },
              [
                _c(
                  "b-form-group",
                  {
                    attrs: {
                      label: "Instituição",
                      "label-class": "font-weight-bold",
                    },
                  },
                  [
                    _c(
                      "b-form-select",
                      {
                        staticClass: "form-control form-control-sm",
                        class: [
                          "form-control form-control-sm",
                          { "is-invalid": _vm.errors.has("instituicao") },
                        ],
                        attrs: {
                          disabled: _vm.loading,
                          name: "instituicao",
                          size: "sm",
                          "data-vv-as": "instituição",
                        },
                        model: {
                          value: _vm.post.instituicao_id,
                          callback: function ($$v) {
                            _vm.$set(_vm.post, "instituicao_id", $$v)
                          },
                          expression: "post.instituicao_id",
                        },
                      },
                      [
                        _c("option", { domProps: { value: null } }, [
                          _vm._v("Selecione"),
                        ]),
                        _vm._v(" "),
                        _vm._l(_vm.instituicoes, function (instituicao) {
                          return _c(
                            "option",
                            {
                              key: instituicao.id,
                              domProps: { value: instituicao.id },
                            },
                            [
                              _vm._v(
                                "\n                        " +
                                  _vm._s(instituicao.instituicao) +
                                  "\n                    "
                              ),
                            ]
                          )
                        }),
                      ],
                      2
                    ),
                    _vm._v(" "),
                    _c(
                      "span",
                      {
                        directives: [
                          {
                            name: "show",
                            rawName: "v-show",
                            value: _vm.errors.has("instituicao"),
                            expression: "errors.has(`instituicao`)",
                          },
                        ],
                        staticClass: "invalid-feedback",
                      },
                      [
                        _vm._v(
                          "\n                        " +
                            _vm._s(_vm.errors.first("instituicao")) +
                            "\n                    "
                        ),
                      ]
                    ),
                  ],
                  1
                ),
              ],
              1
            ),
            _vm._v(" "),
            _c(
              "b-col",
              { attrs: { cols: "12", sm: "6", lg: "6" } },
              [
                _c(
                  "b-form-group",
                  {
                    attrs: {
                      label: "Titulação",
                      "label-class": "font-weight-bold",
                    },
                  },
                  [
                    _c(
                      "b-form-select",
                      {
                        staticClass: "form-control form-control-sm",
                        class: [
                          "form-control form-control-sm",
                          { "is-invalid": _vm.errors.has("titulacao") },
                        ],
                        attrs: {
                          disabled: _vm.loading,
                          name: "titulacao",
                          size: "sm",
                          "data-vv-as": "titulação",
                        },
                        model: {
                          value: _vm.post.titulacao_id,
                          callback: function ($$v) {
                            _vm.$set(_vm.post, "titulacao_id", $$v)
                          },
                          expression: "post.titulacao_id",
                        },
                      },
                      [
                        _c("option", { domProps: { value: null } }, [
                          _vm._v("Selecione"),
                        ]),
                        _vm._v(" "),
                        _vm._l(_vm.titulacoes, function (titulacao) {
                          return _c(
                            "option",
                            {
                              key: titulacao.id,
                              domProps: { value: titulacao.id },
                            },
                            [
                              _vm._v(
                                "\n                        " +
                                  _vm._s(titulacao.titulacao) +
                                  "\n                    "
                              ),
                            ]
                          )
                        }),
                      ],
                      2
                    ),
                    _vm._v(" "),
                    _c(
                      "span",
                      {
                        directives: [
                          {
                            name: "show",
                            rawName: "v-show",
                            value: _vm.errors.has("titulacao"),
                            expression: "errors.has(`titulacao`)",
                          },
                        ],
                        staticClass: "invalid-feedback",
                      },
                      [
                        _vm._v(
                          "\n                        " +
                            _vm._s(_vm.errors.first("titulacao")) +
                            "\n                    "
                        ),
                      ]
                    ),
                  ],
                  1
                ),
              ],
              1
            ),
            _vm._v(" "),
            _c(
              "b-col",
              { attrs: { cols: "12", sm: "6", lg: "4" } },
              [
                _c(
                  "b-form-group",
                  {
                    attrs: {
                      label: "Anuidade",
                      "label-class": "font-weight-bold",
                    },
                  },
                  [
                    _c("b-form-input", {
                      class: [
                        "form-control form-control-sm",
                        { "is-invalid": _vm.errors.has("anuidade") },
                      ],
                      attrs: {
                        name: "anuidade",
                        size: "sm",
                        type: "text",
                        disabled: _vm.loading,
                        "aria-describedby": "input-1-live-feedback",
                        "data-vv-as": "anuidade",
                      },
                      model: {
                        value: _vm.post.anuidade,
                        callback: function ($$v) {
                          _vm.$set(_vm.post, "anuidade", $$v)
                        },
                        expression: "post.anuidade",
                      },
                    }),
                    _vm._v(" "),
                    _c(
                      "span",
                      {
                        directives: [
                          {
                            name: "show",
                            rawName: "v-show",
                            value: _vm.errors.has("anuidade"),
                            expression: "errors.has(`anuidade`)",
                          },
                        ],
                        staticClass: "invalid-feedback",
                      },
                      [
                        _vm._v(
                          "\n                        " +
                            _vm._s(_vm.errors.first("anuidade")) +
                            "\n                    "
                        ),
                      ]
                    ),
                  ],
                  1
                ),
              ],
              1
            ),
            _vm._v(" "),
            _c(
              "b-col",
              { attrs: { cols: "12", sm: "6", lg: "4" } },
              [
                _c(
                  "b-form-group",
                  {
                    attrs: {
                      label: "Número do Sócio",
                      "label-class": "font-weight-bold",
                    },
                  },
                  [
                    _c("b-form-input", {
                      class: [
                        "form-control form-control-sm",
                        { "is-invalid": _vm.errors.has("numero_socio") },
                      ],
                      attrs: {
                        name: "numero_socio",
                        size: "sm",
                        type: "text",
                        disabled: _vm.loading,
                        "aria-describedby": "input-1-live-feedback",
                        "data-vv-as": "numero_socio",
                      },
                      model: {
                        value: _vm.post.numero_socio,
                        callback: function ($$v) {
                          _vm.$set(_vm.post, "numero_socio", $$v)
                        },
                        expression: "post.numero_socio",
                      },
                    }),
                    _vm._v(" "),
                    _c(
                      "span",
                      {
                        directives: [
                          {
                            name: "show",
                            rawName: "v-show",
                            value: _vm.errors.has("numero_socio"),
                            expression: "errors.has(`numero_socio`)",
                          },
                        ],
                        staticClass: "invalid-feedback",
                      },
                      [
                        _vm._v(
                          "\n                        " +
                            _vm._s(_vm.errors.first("numero_socio")) +
                            "\n                    "
                        ),
                      ]
                    ),
                  ],
                  1
                ),
              ],
              1
            ),
            _vm._v(" "),
            _c(
              "b-col",
              { attrs: { cols: "12", sm: "6", lg: "4" } },
              [
                _c(
                  "b-form-group",
                  {
                    attrs: {
                      label: "Obs Insentamos",
                      "label-class": "font-weight-bold",
                    },
                  },
                  [
                    _c("b-form-input", {
                      class: [
                        "form-control form-control-sm",
                        { "is-invalid": _vm.errors.has("obs_isentamos") },
                      ],
                      attrs: {
                        name: "obs_isentamos",
                        size: "sm",
                        type: "text",
                        disabled: _vm.loading,
                        "aria-describedby": "input-1-live-feedback",
                        "data-vv-as": "obs_isentamos",
                      },
                      model: {
                        value: _vm.post.obs_isentamos,
                        callback: function ($$v) {
                          _vm.$set(_vm.post, "obs_isentamos", $$v)
                        },
                        expression: "post.obs_isentamos",
                      },
                    }),
                    _vm._v(" "),
                    _c(
                      "span",
                      {
                        directives: [
                          {
                            name: "show",
                            rawName: "v-show",
                            value: _vm.errors.has("obs_isentamos"),
                            expression: "errors.has(`obs_isentamos`)",
                          },
                        ],
                        staticClass: "invalid-feedback",
                      },
                      [
                        _vm._v(
                          "\n                        " +
                            _vm._s(_vm.errors.first("obs_isentamos")) +
                            "\n                    "
                        ),
                      ]
                    ),
                  ],
                  1
                ),
              ],
              1
            ),
          ],
          1
        ),
        _vm._v(" "),
        _c("hr"),
        _vm._v(" "),
        _c("div", { staticClass: "row" }, [
          _c("div", { staticClass: "col-12 d-flex justify-content-between" }, [
            _c("label", [_vm._v("Endereços")]),
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "col-12" }, [
            _c(
              "div",
              { staticClass: "row" },
              [
                _c("div", { staticClass: "col-12 col-md-6 col-lg-6" }, [
                  _c(
                    "div",
                    { staticClass: "form-group " },
                    [
                      _c("label", { attrs: { for: "" } }, [_vm._v("CEP")]),
                      _vm._v(" "),
                      _c("b-form-input", {
                        directives: [
                          {
                            name: "validate",
                            rawName: "v-validate",
                            value: { min: 9 },
                            expression: "{ min: 9 }",
                          },
                          {
                            name: "mask",
                            rawName: "v-mask",
                            value: "#####-###",
                            expression: "'#####-###'",
                          },
                        ],
                        class: [
                          "form-control form-control-sm",
                          { "is-invalid": _vm.errors.has("cep") },
                        ],
                        attrs: {
                          size: "sm",
                          name: "cep",
                          placeholder: "Digite aqui",
                          "data-vv-as": "CEP",
                          type: "text",
                          disabled: _vm.loading,
                        },
                        on: {
                          change: function ($event) {
                            return _vm.getCep()
                          },
                        },
                        model: {
                          value: _vm.post.enderecos.cep,
                          callback: function ($$v) {
                            _vm.$set(_vm.post.enderecos, "cep", $$v)
                          },
                          expression: "post.enderecos.cep",
                        },
                      }),
                      _vm._v(" "),
                      _c(
                        "span",
                        {
                          directives: [
                            {
                              name: "show",
                              rawName: "v-show",
                              value: _vm.errors.has("cep"),
                              expression: "errors.has(`cep`)",
                            },
                          ],
                          staticClass: "invalid-feedback d-block",
                        },
                        [
                          _vm._v(
                            "\n                                " +
                              _vm._s(_vm.errors.first("cep")) +
                              "\n                            "
                          ),
                        ]
                      ),
                    ],
                    1
                  ),
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "col-12 col-md-6 col-lg-6" }, [
                  _c(
                    "div",
                    { staticClass: "form-group " },
                    [
                      _c("label", { attrs: { for: "" } }, [
                        _vm._v("logradouro"),
                      ]),
                      _vm._v(" "),
                      _c("b-form-input", {
                        class: [
                          "form-control form-control-sm",
                          { "is-invalid": _vm.errors.has("logradouro") },
                        ],
                        attrs: {
                          size: "sm",
                          name: "logradouro",
                          "data-vv-as": "logradouro",
                          type: "text",
                          disabled: _vm.loading,
                        },
                        model: {
                          value: _vm.post.enderecos.logradouro,
                          callback: function ($$v) {
                            _vm.$set(_vm.post.enderecos, "logradouro", $$v)
                          },
                          expression: "post.enderecos.logradouro",
                        },
                      }),
                      _vm._v(" "),
                      _c(
                        "span",
                        {
                          directives: [
                            {
                              name: "show",
                              rawName: "v-show",
                              value: _vm.errors.has("logradouro"),
                              expression: "errors.has(`logradouro`)",
                            },
                          ],
                          staticClass: "invalid-feedback d-block",
                        },
                        [
                          _vm._v(
                            "\n                                " +
                              _vm._s(_vm.errors.first("logradouro")) +
                              "\n                            "
                          ),
                        ]
                      ),
                    ],
                    1
                  ),
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "col-12 col-md-6 col-lg-6" }, [
                  _c(
                    "div",
                    { staticClass: "form-group" },
                    [
                      _c("label", { staticClass: "font-weight-bold" }, [
                        _vm._v("Número"),
                      ]),
                      _vm._v(" "),
                      _c("b-form-input", {
                        class: [
                          "form-control form-control-sm",
                          { "is-invalid": _vm.errors.has("numero") },
                        ],
                        attrs: {
                          size: "sm",
                          name: "numero",
                          "data-vv-as": "Número",
                          type: "number",
                          disabled: _vm.loading,
                        },
                        model: {
                          value: _vm.post.enderecos.numero,
                          callback: function ($$v) {
                            _vm.$set(_vm.post.enderecos, "numero", $$v)
                          },
                          expression: "post.enderecos.numero",
                        },
                      }),
                      _vm._v(" "),
                      _c(
                        "span",
                        {
                          directives: [
                            {
                              name: "show",
                              rawName: "v-show",
                              value: _vm.errors.has("numero"),
                              expression: "errors.has(`numero`)",
                            },
                          ],
                          staticClass: "invalid-feedback d-block",
                        },
                        [
                          _vm._v(
                            "\n                                " +
                              _vm._s(_vm.errors.first("numero")) +
                              "\n                            "
                          ),
                        ]
                      ),
                    ],
                    1
                  ),
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "col-12 col-md-6 col-lg-6" }, [
                  _c(
                    "div",
                    { staticClass: "form-group" },
                    [
                      _c("label", { staticClass: "font-weight-bold" }, [
                        _vm._v("Complemento"),
                      ]),
                      _vm._v(" "),
                      _c("b-form-input", {
                        class: [
                          "form-control form-control-sm",
                          { "is-invalid": _vm.errors.has("complemento") },
                        ],
                        attrs: {
                          size: "sm",
                          name: "complemento",
                          "data-vv-as": "Complemento",
                          type: "text",
                          disabled: _vm.loading,
                        },
                        model: {
                          value: _vm.post.enderecos.complemento,
                          callback: function ($$v) {
                            _vm.$set(_vm.post.enderecos, "complemento", $$v)
                          },
                          expression: "post.enderecos.complemento",
                        },
                      }),
                      _vm._v(" "),
                      _c(
                        "span",
                        {
                          directives: [
                            {
                              name: "show",
                              rawName: "v-show",
                              value: _vm.errors.has("complemento"),
                              expression: "errors.has(`complemento`)",
                            },
                          ],
                          staticClass: "invalid-feedback d-block",
                        },
                        [
                          _vm._v(
                            "\n                                " +
                              _vm._s(_vm.errors.first("complemento")) +
                              "\n                            "
                          ),
                        ]
                      ),
                    ],
                    1
                  ),
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "col-12 col-md-6 col-lg-6" }, [
                  _c(
                    "div",
                    { staticClass: "form-group" },
                    [
                      _c("label", { staticClass: "font-weight-bold" }, [
                        _vm._v("Bairro"),
                      ]),
                      _vm._v(" "),
                      _c("b-form-input", {
                        class: [
                          "form-control form-control-sm",
                          { "is-invalid": _vm.errors.has("bairro") },
                        ],
                        attrs: {
                          size: "sm",
                          name: "bairro",
                          "data-vv-as": "Bairro",
                          type: "text",
                          disabled: _vm.loading,
                        },
                        model: {
                          value: _vm.post.enderecos.bairro,
                          callback: function ($$v) {
                            _vm.$set(_vm.post.enderecos, "bairro", $$v)
                          },
                          expression: "post.enderecos.bairro",
                        },
                      }),
                      _vm._v(" "),
                      _c(
                        "span",
                        {
                          directives: [
                            {
                              name: "show",
                              rawName: "v-show",
                              value: _vm.errors.has("bairro"),
                              expression: "errors.has(`bairro`)",
                            },
                          ],
                          staticClass: "invalid-feedback d-block",
                        },
                        [
                          _vm._v(
                            "\n                                " +
                              _vm._s(_vm.errors.first("bairro")) +
                              "\n                            "
                          ),
                        ]
                      ),
                    ],
                    1
                  ),
                ]),
                _vm._v(" "),
                _c(
                  "div",
                  { staticClass: "form-group col-12 col-md-6 col-lg-6" },
                  [
                    _c("label", [_vm._v("Estado")]),
                    _vm._v(" "),
                    _c("v-select", {
                      staticClass: "flex-fill",
                      class: [{ "v-select-invalid": _vm.errors.has("estado") }],
                      attrs: {
                        options: _vm.estados,
                        "data-vv-as": "estado",
                        selectOnTab: true,
                        disabled: _vm.loading,
                        label: "sigla",
                        name: "estado",
                      },
                      on: {
                        input: function ($event) {
                          return _vm.getMunicipios()
                        },
                      },
                      scopedSlots: _vm._u([
                        {
                          key: "no-options",
                          fn: function (ref) {
                            var search = ref.search
                            var searching = ref.searching
                            return [
                              searching
                                ? [
                                    _vm._v(
                                      "\n                                    Nada encontrado com "
                                    ),
                                    _c("em", [_vm._v(_vm._s(search))]),
                                    _vm._v(
                                      ".\n                                "
                                    ),
                                  ]
                                : _c(
                                    "em",
                                    { staticStyle: { opacity: "0.5" } },
                                    [_vm._v("Começe a digitar algo.")]
                                  ),
                            ]
                          },
                        },
                      ]),
                      model: {
                        value: _vm.post.enderecos.estado,
                        callback: function ($$v) {
                          _vm.$set(_vm.post.enderecos, "estado", $$v)
                        },
                        expression: "post.enderecos.estado",
                      },
                    }),
                    _vm._v(" "),
                    _c(
                      "span",
                      {
                        directives: [
                          {
                            name: "show",
                            rawName: "v-show",
                            value: _vm.errors.has("estado"),
                            expression: "errors.has(`estado`)",
                          },
                        ],
                        staticClass: "v-select-invalid-feedback",
                      },
                      [
                        _vm._v(
                          "\n                            " +
                            _vm._s(_vm.errors.first("estado")) +
                            "\n                        "
                        ),
                      ]
                    ),
                  ],
                  1
                ),
                _vm._v(" "),
                _c(
                  "div",
                  { staticClass: "form-group col-12 col-md-6 col-lg-6" },
                  [
                    _c("label", [_vm._v("Município")]),
                    _vm._v(" "),
                    _c("v-select", {
                      staticClass: "flex-fill",
                      class: {
                        "v-select-invalid": _vm.errors.has("municipio"),
                      },
                      attrs: {
                        name: "municipio",
                        disabled: _vm.loading,
                        options: _vm.municipios,
                        selectOnTab: false,
                        label: "nome",
                        "data-vv-as": "municipio",
                      },
                      model: {
                        value: _vm.post.enderecos.municipio,
                        callback: function ($$v) {
                          _vm.$set(_vm.post.enderecos, "municipio", $$v)
                        },
                        expression: "post.enderecos.municipio",
                      },
                    }),
                    _vm._v(" "),
                    _c(
                      "span",
                      {
                        directives: [
                          {
                            name: "show",
                            rawName: "v-show",
                            value: _vm.errors.has("municipio"),
                            expression: "errors.has(`municipio`)",
                          },
                        ],
                        staticClass: "v-select-invalid-feedback",
                      },
                      [
                        _vm._v(
                          "\n                            " +
                            _vm._s(_vm.errors.first("municipio")) +
                            "\n                        "
                        ),
                      ]
                    ),
                  ],
                  1
                ),
                _vm._v(" "),
                _c(
                  "b-col",
                  { attrs: { cols: "12", sm: "6", lg: "6" } },
                  [
                    _c(
                      "b-form-group",
                      {
                        attrs: {
                          label: "País",
                          "label-class": "font-weight-bold",
                        },
                      },
                      [
                        _c("b-form-input", {
                          class: [
                            "form-control form-control-sm",
                            { "is-invalid": _vm.errors.has("pais") },
                          ],
                          attrs: {
                            name: "pais",
                            size: "sm",
                            type: "text",
                            disabled: _vm.loading,
                            "aria-describedby": "input-1-live-feedback",
                            "data-vv-as": "País",
                          },
                          model: {
                            value: _vm.post.enderecos.pais,
                            callback: function ($$v) {
                              _vm.$set(_vm.post.enderecos, "pais", $$v)
                            },
                            expression: "post.enderecos.pais",
                          },
                        }),
                        _vm._v(" "),
                        _c(
                          "span",
                          {
                            directives: [
                              {
                                name: "show",
                                rawName: "v-show",
                                value: _vm.errors.has("pais"),
                                expression: "errors.has(`pais`)",
                              },
                            ],
                            staticClass: "invalid-feedback",
                          },
                          [
                            _vm._v(
                              "\n                            " +
                                _vm._s(_vm.errors.first("pais")) +
                                "\n                        "
                            ),
                          ]
                        ),
                      ],
                      1
                    ),
                  ],
                  1
                ),
              ],
              1
            ),
          ]),
        ]),
        _vm._v(" "),
        _c("hr"),
        _vm._v(" "),
        _c("div", { staticClass: "row" }, [
          _c("div", { staticClass: "col-12" }, [
            _c("div", { staticClass: "form-group" }, [
              _c("label", { attrs: { for: "todos_isencoes_id" } }, [
                _vm._v("Tipo de Isenção Nacional:"),
              ]),
              _c("br"),
              _vm._v(" "),
              _c(
                "div",
                {
                  staticClass: "btn-group",
                  staticStyle: { "margin-bottom": "-10px" },
                },
                [
                  _c(
                    "div",
                    { staticClass: "switch-field" },
                    _vm._l(_vm.tipos_isencoes, function (isencao_tipo, index) {
                      return _c("span", { key: index }, [
                        _c("input", {
                          directives: [
                            {
                              name: "model",
                              rawName: "v-model",
                              value: _vm.post.todos_isencoes_id,
                              expression: "post.todos_isencoes_id",
                            },
                          ],
                          staticClass:
                            "form-control radio-inline radio_lista radio",
                          attrs: {
                            disabled: _vm.loading,
                            id: "todos_isencoes_" + index,
                            name: "tipos_isencoes[]",
                            type: "checkbox",
                          },
                          domProps: {
                            value: isencao_tipo.id,
                            checked: Array.isArray(_vm.post.todos_isencoes_id)
                              ? _vm._i(
                                  _vm.post.todos_isencoes_id,
                                  isencao_tipo.id
                                ) > -1
                              : _vm.post.todos_isencoes_id,
                          },
                          on: {
                            change: function ($event) {
                              var $$a = _vm.post.todos_isencoes_id,
                                $$el = $event.target,
                                $$c = $$el.checked ? true : false
                              if (Array.isArray($$a)) {
                                var $$v = isencao_tipo.id,
                                  $$i = _vm._i($$a, $$v)
                                if ($$el.checked) {
                                  $$i < 0 &&
                                    _vm.$set(
                                      _vm.post,
                                      "todos_isencoes_id",
                                      $$a.concat([$$v])
                                    )
                                } else {
                                  $$i > -1 &&
                                    _vm.$set(
                                      _vm.post,
                                      "todos_isencoes_id",
                                      $$a
                                        .slice(0, $$i)
                                        .concat($$a.slice($$i + 1))
                                    )
                                }
                              } else {
                                _vm.$set(_vm.post, "todos_isencoes_id", $$c)
                              }
                            },
                          },
                        }),
                        _c(
                          "label",
                          {
                            key: "label_" + index,
                            staticClass: "mr-2",
                            attrs: { for: "todos_isencoes_" + index },
                          },
                          [_vm._v(_vm._s(isencao_tipo.descricao))]
                        ),
                      ])
                    }),
                    0
                  ),
                ]
              ),
            ]),
          ]),
        ]),
        _vm._v(" "),
        _c("hr"),
        _vm._v(" "),
        _c("div", { staticClass: "row" }, [
          _c("div", { staticClass: "col-12" }, [
            _c("div", { staticClass: "form-group" }, [
              _c("label", { attrs: { for: "todos_tipos_id" } }, [
                _vm._v("Tipo de Acesso:"),
              ]),
              _c("br"),
              _vm._v(" "),
              _c(
                "div",
                {
                  staticClass: "btn-group",
                  staticStyle: { "margin-bottom": "-10px" },
                },
                [
                  _c(
                    "div",
                    { staticClass: "switch-field" },
                    _vm._l(_vm.usersTypes, function (userType, index) {
                      return _c("span", { key: index }, [
                        _c("input", {
                          directives: [
                            {
                              name: "model",
                              rawName: "v-model",
                              value: _vm.post.todos_tipos_id,
                              expression: "post.todos_tipos_id",
                            },
                          ],
                          staticClass:
                            "form-control radio-inline radio_lista radio",
                          attrs: {
                            disabled: _vm.loading,
                            id: "todos_tipos_" + index,
                            name: "usersTypes[]",
                            type: "checkbox",
                          },
                          domProps: {
                            value: userType.id,
                            checked: Array.isArray(_vm.post.todos_tipos_id)
                              ? _vm._i(_vm.post.todos_tipos_id, userType.id) >
                                -1
                              : _vm.post.todos_tipos_id,
                          },
                          on: {
                            change: function ($event) {
                              var $$a = _vm.post.todos_tipos_id,
                                $$el = $event.target,
                                $$c = $$el.checked ? true : false
                              if (Array.isArray($$a)) {
                                var $$v = userType.id,
                                  $$i = _vm._i($$a, $$v)
                                if ($$el.checked) {
                                  $$i < 0 &&
                                    _vm.$set(
                                      _vm.post,
                                      "todos_tipos_id",
                                      $$a.concat([$$v])
                                    )
                                } else {
                                  $$i > -1 &&
                                    _vm.$set(
                                      _vm.post,
                                      "todos_tipos_id",
                                      $$a
                                        .slice(0, $$i)
                                        .concat($$a.slice($$i + 1))
                                    )
                                }
                              } else {
                                _vm.$set(_vm.post, "todos_tipos_id", $$c)
                              }
                            },
                          },
                        }),
                        _c(
                          "label",
                          {
                            key: "label_" + index,
                            staticClass: "mr-2",
                            attrs: { for: "todos_tipos_" + index },
                          },
                          [_vm._v(_vm._s(userType.descricao))]
                        ),
                      ])
                    }),
                    0
                  ),
                ]
              ),
            ]),
          ]),
        ]),
        _vm._v(" "),
        _c("hr"),
        _vm._v(" "),
        _vm.post.todos_tipos_id != 1
          ? _c("div", { staticClass: "row" }, [
              _c("div", { staticClass: "col-12" }, [
                _c("label", { attrs: { for: "ativo" } }, [
                  _vm._v("Telas Liberadas:"),
                ]),
                _c("br"),
                _vm._v(" "),
                _c(
                  "div",
                  { staticClass: "switch-field-one" },
                  _vm._l(_vm.acessos, function (acesso, index) {
                    return _c("span", { key: index }, [
                      _c("input", {
                        directives: [
                          {
                            name: "model",
                            rawName: "v-model",
                            value: _vm.post.acessos,
                            expression: "post.acessos",
                          },
                        ],
                        staticClass:
                          "form-control radio-inline radio_lista radio",
                        attrs: {
                          disabled: _vm.loading,
                          id: "ace_" + index,
                          name: "acessos[]",
                          type: "checkbox",
                        },
                        domProps: {
                          value: acesso.id,
                          checked: Array.isArray(_vm.post.acessos)
                            ? _vm._i(_vm.post.acessos, acesso.id) > -1
                            : _vm.post.acessos,
                        },
                        on: {
                          change: function ($event) {
                            var $$a = _vm.post.acessos,
                              $$el = $event.target,
                              $$c = $$el.checked ? true : false
                            if (Array.isArray($$a)) {
                              var $$v = acesso.id,
                                $$i = _vm._i($$a, $$v)
                              if ($$el.checked) {
                                $$i < 0 &&
                                  _vm.$set(
                                    _vm.post,
                                    "acessos",
                                    $$a.concat([$$v])
                                  )
                              } else {
                                $$i > -1 &&
                                  _vm.$set(
                                    _vm.post,
                                    "acessos",
                                    $$a.slice(0, $$i).concat($$a.slice($$i + 1))
                                  )
                              }
                            } else {
                              _vm.$set(_vm.post, "acessos", $$c)
                            }
                          },
                        },
                      }),
                      _c(
                        "label",
                        {
                          key: "label_" + index,
                          staticClass: "mr-2",
                          attrs: { for: "ace_" + index },
                        },
                        [_vm._v(_vm._s(acesso.pagina))]
                      ),
                    ])
                  }),
                  0
                ),
              ]),
            ])
          : _c("div", [
              _c("div", { staticClass: "col-12" }, [
                _c("div", { staticClass: "row mt-2 alert alert-warning" }, [
                  _c("span", {}, [
                    _vm._v(
                      "Atenção! esse usuário pode ter acesso a todo o sistema."
                    ),
                  ]),
                ]),
              ]),
            ]),
      ],
    ],
    2
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ })

}]);