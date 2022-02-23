"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["form-usuario"],{

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
      usersTypes: []
    }, _defineProperty(_ref, "loading", false), _defineProperty(_ref, "location", null), _defineProperty(_ref, "verify", null), _defineProperty(_ref, "post", {
      id: null,
      name: null,
      email: null,
      todos_tipos_id: 3,
      tipo_contratacao: null,
      ativo: 0,
      acessos: [],
      enderecos: [{
        cep: null,
        logradouro: null,
        numero: null,
        complemento: null,
        bairro: null,
        municipio: null,
        municipio_id: null,
        estado: null,
        deleted: false
      }],
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
      var _this = this;

      if (this.selected) {
        this.$forceUpdate();
        this.post.id = this.selected.id;
        this.post.name = this.selected.name;
        this.post.email = this.selected.email;
        this.post.todos_tipos_id = this.selected.todos_tipos_id; // this.post.departamento_id = this.selected.departamento_id
        // this.post.empresa = this.selected.empresa
        // this.post.cnpj_cpf = this.selected.cnpj_cpf
        // this.post.empresa_id = this.selected.empresa_id

        this.post.ativo = this.selected.ativo;
        this.post.tipo_contratacao = this.selected.tipo_contratacao;
        this.post.acessos = this.access;
        this.post._method = 'put';
        this.post.enderecos = [{
          logradouro: null,
          cep: null,
          numero: null,
          bairro: null,
          complemento: null,
          municipio: null,
          municipio_id: null,
          estado: null,
          deleted: false
        }];

        if (this.selected.enderecos.length > 0) {
          this.post.enderecos = [];
          this.selected.enderecos.forEach(function (endereco, indice) {
            _this.post.enderecos.push({
              id: endereco.id,
              cep: endereco.cep,
              logradouro: endereco.logradouro,
              numero: endereco.numero,
              complemento: endereco.complemento,
              bairro: endereco.bairro,
              municipio: endereco.municipio,
              estado: endereco.municipio.estado,
              municipio_id: endereco.municipio_id,
              latitude: endereco.latitude,
              longitude: endereco.longitude,
              user_id: _this.post.id,
              deleted: false
            });

            return _this.getMunicipios(indice);
          });
        }
      } else {
        this.clear();
      }
    }
  },
  computed: {
    access: function access() {
      return this.selected && this.selected.acessos ? this.selected.acessos.map(function (res) {
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
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                _context.next = 2;
                return axios.get("".concat("", "/get/estados")).then(function (res) {
                  _this2.estados = res.data;
                });

              case 2:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    },
    save: function save() {
      var _this3 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee3() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee3$(_context3) {
          while (1) {
            switch (_context3.prev = _context3.next) {
              case 0:
                _this3.loading = true;
                _context3.next = 3;
                return _this3.$validator.validateAll().then(function (valid) {
                  if (valid) {
                    _this3.message('Aguarde...', 'Estamos salvando suas informações', 'info', -1);

                    _this3.post.enderecos.forEach( /*#__PURE__*/function () {
                      var _ref2 = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2(element, indice) {
                        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
                          while (1) {
                            switch (_context2.prev = _context2.next) {
                              case 0:
                                if (!(element.logradouro && element.cep)) {
                                  _context2.next = 4;
                                  break;
                                }

                                _context2.next = 3;
                                return _this3.getAdress(element, indice);

                              case 3:
                                return _context2.abrupt("return", _context2.sent);

                              case 4:
                              case "end":
                                return _context2.stop();
                            }
                          }
                        }, _callee2);
                      }));

                      return function (_x, _x2) {
                        return _ref2.apply(this, arguments);
                      };
                    }());

                    setTimeout(function () {
                      axios.post("".concat("", "/admin/usuarios").concat(_this3.url), _this3.post).then(function (res) {
                        _this3.clear();

                        if (res.status == 201) {
                          _this3.loading = false;

                          _this3.$emit('store', res.data.response);
                        } else {
                          _this3.loading = false;

                          _this3.$emit('update', res.data.response);
                        }

                        _this3.message('Sucesso', res.status == 201 ? 'Registro cadastrado.' : 'Registro atualizado.', 'success');
                      })["catch"](function (error) {
                        if (error.response.status == 422) {
                          if (error.response.data.message == "The given data was invalid.") {
                            _this3.loading = false;
                            return _this3.message('Campos Obrigatórios', 'Preencha todos os campos obrigatórios', 'error');
                          }
                        }

                        if (error.response.status == 500) {
                          _this3.loading = false;

                          _this3.message('Erro', 'Por favor tente novamente.', 'error');
                        }

                        if (error.response.status == 403) {
                          if (error.response.data.message == "This action is unauthorized.") {
                            _this3.loading = false;

                            _this3.message('Erro', 'Ação não autorizada.', 'error');
                          }
                        }
                      });
                    }, 1000);
                  } else {
                    _this3.loading = false;

                    _this3.message('Campos Obrigatórios', 'Preencha todos os campos obrigatórios', 'error');
                  }
                });

              case 3:
              case "end":
                return _context3.stop();
            }
          }
        }, _callee3);
      }))();
    },
    clear: function clear() {
      this.post.id = null;
      this.post.email = null;
      this.post.name = null;
      this.post.todos_tipos_id = 3;
      this.post.ativo = 0;
      this.post.tipo_contratacao = null;
      this.post.departamento_id = null;
      this.post.cnpj_cpf = null;
      this.post.empresa_id = null;
      this.post.empresa = null;
      this.post.password = null;
      this.post.enderecos = [{
        logradouro: null,
        cep: null,
        numero: null,
        complemento: null,
        bairro: null,
        municipio: null,
        municipio_id: null,
        latitude: null,
        longitude: null,
        estado: null,
        deleted: false
      }];
      this.post.acessos = [], this.post._method = 'post';
      this.$validator.reset('name');
      this.$validator.reset('email');
    }
  },
  created: function created() {
    var _this4 = this;

    axios.get("" + '/get/tiposusuarios').then(function (res) {
      _this4.usersTypes = res.data;
    });
    axios.get("" + '/get/acessos').then(function (res) {
      _this4.acessos = res.data;
    });
    this.getEstados();
  }
});

/***/ }),

/***/ "./resources/js/components/mixins/global-mixins.js":
/*!*********************************************************!*\
  !*** ./resources/js/components/mixins/global-mixins.js ***!
  \*********************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var moment__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! moment */ "./node_modules/moment/moment.js");
/* harmony import */ var moment__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(moment__WEBPACK_IMPORTED_MODULE_0__);

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  data: function data() {
    return {
      loading: false
    };
  },
  methods: {
    message: function message(title, _message, type) {
      var duration = arguments.length > 3 && arguments[3] !== undefined ? arguments[3] : null;
      this.$notify({
        group: 'submit',
        clean: true
      });
      this.$notify({
        group: 'submit',
        title: title,
        text: _message,
        type: type,
        duration: duration ? duration : 3000
      });
    }
  }
});

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
/* harmony import */ var _FormUsuario_vue_vue_type_template_id_9e539d64___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./FormUsuario.vue?vue&type=template&id=9e539d64& */ "./resources/js/components/admin/usuario/FormUsuario.vue?vue&type=template&id=9e539d64&");
/* harmony import */ var _FormUsuario_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./FormUsuario.vue?vue&type=script&lang=js& */ "./resources/js/components/admin/usuario/FormUsuario.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _FormUsuario_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _FormUsuario_vue_vue_type_template_id_9e539d64___WEBPACK_IMPORTED_MODULE_0__.render,
  _FormUsuario_vue_vue_type_template_id_9e539d64___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/admin/usuario/FormUsuario.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

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

/***/ "./resources/js/components/admin/usuario/FormUsuario.vue?vue&type=template&id=9e539d64&":
/*!**********************************************************************************************!*\
  !*** ./resources/js/components/admin/usuario/FormUsuario.vue?vue&type=template&id=9e539d64& ***!
  \**********************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_FormUsuario_vue_vue_type_template_id_9e539d64___WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   "staticRenderFns": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_FormUsuario_vue_vue_type_template_id_9e539d64___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_FormUsuario_vue_vue_type_template_id_9e539d64___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./FormUsuario.vue?vue&type=template&id=9e539d64& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/admin/usuario/FormUsuario.vue?vue&type=template&id=9e539d64&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/admin/usuario/FormUsuario.vue?vue&type=template&id=9e539d64&":
/*!*************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/admin/usuario/FormUsuario.vue?vue&type=template&id=9e539d64& ***!
  \*************************************************************************************************************************************************************************************************************************************/
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
                          value: { required: true },
                          expression: "{ required: true }",
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
                          value: {
                            required: true,
                            email: true,
                            emailCheck: _vm.post.id,
                          },
                          expression:
                            "{ required: true, email: true, emailCheck: post.id }",
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
                        type: "password",
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
                        { "is-invalid": _vm.errors.has("name") },
                      ],
                      attrs: {
                        name: "name",
                        size: "sm",
                        type: "date",
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
            _vm._v(" "),
            _c(
              "b-col",
              { attrs: { cols: "12", sm: "6", lg: "4" } },
              [
                _c(
                  "b-form-group",
                  {
                    attrs: { label: "CNPJ", "label-class": "font-weight-bold" },
                  },
                  [
                    _c("b-form-input", {
                      directives: [
                        {
                          name: "mask",
                          rawName: "v-mask",
                          value: ["###.###.###-##", "##.###.###/####-##"],
                          expression:
                            "['###.###.###-##', '##.###.###/####-##']",
                        },
                        {
                          name: "validate",
                          rawName: "v-validate",
                          value: { required: true },
                          expression: "{ required: true }",
                        },
                      ],
                      class: [
                        "form-control form-control-sm",
                        { "is-invalid": _vm.errors.has("cnpj_cpf") },
                      ],
                      attrs: {
                        name: "cnpj_cpf",
                        size: "sm",
                        disabled: _vm.loading,
                        type: "text",
                        "aria-describedby": "input-1-live-feedback",
                        "data-vv-as": "CNPJ/CPF",
                      },
                      model: {
                        value: _vm.post.cnpj_cpf,
                        callback: function ($$v) {
                          _vm.$set(_vm.post, "cnpj_cpf", $$v)
                        },
                        expression: "post.cnpj_cpf",
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
                            value: _vm.errors.has("cnpj_cpf"),
                            expression: "errors.has(`cnpj_cpf`)",
                          },
                        ],
                        staticClass: "invalid-feedback",
                      },
                      [
                        _vm._v(
                          "\n                        " +
                            _vm._s(_vm.errors.first("cnpj_cpf")) +
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
                  { attrs: { label: "RG", "label-class": "font-weight-bold" } },
                  [
                    _c("b-form-input", {
                      directives: [
                        {
                          name: "mask",
                          rawName: "v-mask",
                          value: ["###.###.###-##", "##.###.###/####-##"],
                          expression:
                            "['###.###.###-##', '##.###.###/####-##']",
                        },
                        {
                          name: "validate",
                          rawName: "v-validate",
                          value: { required: true },
                          expression: "{ required: true }",
                        },
                      ],
                      class: [
                        "form-control form-control-sm",
                        { "is-invalid": _vm.errors.has("cnpj_cpf") },
                      ],
                      attrs: {
                        name: "cnpj_cpf",
                        size: "sm",
                        disabled: _vm.loading,
                        type: "text",
                        "aria-describedby": "input-1-live-feedback",
                        "data-vv-as": "CNPJ/CPF",
                      },
                      model: {
                        value: _vm.post.cnpj_cpf,
                        callback: function ($$v) {
                          _vm.$set(_vm.post, "cnpj_cpf", $$v)
                        },
                        expression: "post.cnpj_cpf",
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
                            value: _vm.errors.has("cnpj_cpf"),
                            expression: "errors.has(`cnpj_cpf`)",
                          },
                        ],
                        staticClass: "invalid-feedback",
                      },
                      [
                        _vm._v(
                          "\n                        " +
                            _vm._s(_vm.errors.first("cnpj_cpf")) +
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
                      label: "Orgão expedidor",
                      "label-class": "font-weight-bold",
                    },
                  },
                  [
                    _c("b-form-input", {
                      directives: [
                        {
                          name: "mask",
                          rawName: "v-mask",
                          value: ["###.###.###-##", "##.###.###/####-##"],
                          expression:
                            "['###.###.###-##', '##.###.###/####-##']",
                        },
                        {
                          name: "validate",
                          rawName: "v-validate",
                          value: { required: true },
                          expression: "{ required: true }",
                        },
                      ],
                      class: [
                        "form-control form-control-sm",
                        { "is-invalid": _vm.errors.has("cnpj_cpf") },
                      ],
                      attrs: {
                        name: "cnpj_cpf",
                        size: "sm",
                        disabled: _vm.loading,
                        type: "text",
                        "aria-describedby": "input-1-live-feedback",
                        "data-vv-as": "CNPJ/CPF",
                      },
                      model: {
                        value: _vm.post.cnpj_cpf,
                        callback: function ($$v) {
                          _vm.$set(_vm.post, "cnpj_cpf", $$v)
                        },
                        expression: "post.cnpj_cpf",
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
                            value: _vm.errors.has("cnpj_cpf"),
                            expression: "errors.has(`cnpj_cpf`)",
                          },
                        ],
                        staticClass: "invalid-feedback",
                      },
                      [
                        _vm._v(
                          "\n                        " +
                            _vm._s(_vm.errors.first("cnpj_cpf")) +
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
                          value: ["###.###.###-##", "##.###.###/####-##"],
                          expression:
                            "['###.###.###-##', '##.###.###/####-##']",
                        },
                        {
                          name: "validate",
                          rawName: "v-validate",
                          value: { required: true },
                          expression: "{ required: true }",
                        },
                      ],
                      class: [
                        "form-control form-control-sm",
                        { "is-invalid": _vm.errors.has("cnpj_cpf") },
                      ],
                      attrs: {
                        name: "cnpj_cpf",
                        size: "sm",
                        disabled: _vm.loading,
                        type: "text",
                        "aria-describedby": "input-1-live-feedback",
                        "data-vv-as": "CNPJ/CPF",
                      },
                      model: {
                        value: _vm.post.cnpj_cpf,
                        callback: function ($$v) {
                          _vm.$set(_vm.post, "cnpj_cpf", $$v)
                        },
                        expression: "post.cnpj_cpf",
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
                            value: _vm.errors.has("cnpj_cpf"),
                            expression: "errors.has(`cnpj_cpf`)",
                          },
                        ],
                        staticClass: "invalid-feedback",
                      },
                      [
                        _vm._v(
                          "\n                        " +
                            _vm._s(_vm.errors.first("cnpj_cpf")) +
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
                          value: ["###.###.###-##", "##.###.###/####-##"],
                          expression:
                            "['###.###.###-##', '##.###.###/####-##']",
                        },
                        {
                          name: "validate",
                          rawName: "v-validate",
                          value: { required: true },
                          expression: "{ required: true }",
                        },
                      ],
                      class: [
                        "form-control form-control-sm",
                        { "is-invalid": _vm.errors.has("cnpj_cpf") },
                      ],
                      attrs: {
                        name: "cnpj_cpf",
                        size: "sm",
                        disabled: _vm.loading,
                        type: "text",
                        "aria-describedby": "input-1-live-feedback",
                        "data-vv-as": "CNPJ/CPF",
                      },
                      model: {
                        value: _vm.post.cnpj_cpf,
                        callback: function ($$v) {
                          _vm.$set(_vm.post, "cnpj_cpf", $$v)
                        },
                        expression: "post.cnpj_cpf",
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
                            value: _vm.errors.has("cnpj_cpf"),
                            expression: "errors.has(`cnpj_cpf`)",
                          },
                        ],
                        staticClass: "invalid-feedback",
                      },
                      [
                        _vm._v(
                          "\n                        " +
                            _vm._s(_vm.errors.first("cnpj_cpf")) +
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
              "div",
              { staticClass: "form-group col-12 col-md-6 col-lg-4" },
              [
                _c("label", [_vm._v("Sexo")]),
                _vm._v(" "),
                _c("v-select", {
                  directives: [
                    {
                      name: "validate",
                      rawName: "v-validate",
                      value: { required: true },
                      expression: "{ required: true }",
                    },
                  ],
                  staticClass: "flex-fill",
                  class: [
                    {
                      "v-select-invalid": _vm.errors.has("estado" + _vm.indice),
                    },
                  ],
                  attrs: {
                    options: _vm.estados,
                    "data-vv-as": "estado",
                    selectOnTab: true,
                    disabled: _vm.loading,
                    label: "sigla",
                    name: "estado" + _vm.indice,
                  },
                  on: {
                    input: function ($event) {
                      return _vm.getMunicipios(_vm.indice)
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
                                  "\n                            Nada encontrado com "
                                ),
                                _c("em", [_vm._v(_vm._s(search))]),
                                _vm._v(".\n                        "),
                              ]
                            : _c("em", { staticStyle: { opacity: "0.5" } }, [
                                _vm._v("Começe a digitar algo."),
                              ]),
                        ]
                      },
                    },
                  ]),
                  model: {
                    value: _vm.post.sexo,
                    callback: function ($$v) {
                      _vm.$set(_vm.post, "sexo", $$v)
                    },
                    expression: "post.sexo",
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
                        value: _vm.errors.has("estado" + _vm.indice),
                        expression: "errors.has(`estado${indice}`)",
                      },
                    ],
                    staticClass: "v-select-invalid-feedback",
                  },
                  [
                    _vm._v(
                      "\n                    " +
                        _vm._s(_vm.errors.first("estado" + _vm.indice)) +
                        "\n                "
                    ),
                  ]
                ),
              ],
              1
            ),
            _vm._v(" "),
            _c(
              "div",
              { staticClass: "form-group col-12 col-md-6 col-lg-4" },
              [
                _c("label", [_vm._v("Instituição")]),
                _vm._v(" "),
                _c("v-select", {
                  directives: [
                    {
                      name: "validate",
                      rawName: "v-validate",
                      value: { required: true },
                      expression: "{ required: true }",
                    },
                  ],
                  staticClass: "flex-fill",
                  class: [
                    {
                      "v-select-invalid": _vm.errors.has("estado" + _vm.indice),
                    },
                  ],
                  attrs: {
                    options: _vm.estados,
                    "data-vv-as": "estado",
                    selectOnTab: true,
                    disabled: _vm.loading,
                    label: "sigla",
                    name: "estado" + _vm.indice,
                  },
                  on: {
                    input: function ($event) {
                      return _vm.getMunicipios(_vm.indice)
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
                                  "\n                            Nada encontrado com "
                                ),
                                _c("em", [_vm._v(_vm._s(search))]),
                                _vm._v(".\n                        "),
                              ]
                            : _c("em", { staticStyle: { opacity: "0.5" } }, [
                                _vm._v("Começe a digitar algo."),
                              ]),
                        ]
                      },
                    },
                  ]),
                  model: {
                    value: _vm.post.sexo,
                    callback: function ($$v) {
                      _vm.$set(_vm.post, "sexo", $$v)
                    },
                    expression: "post.sexo",
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
                        value: _vm.errors.has("estado" + _vm.indice),
                        expression: "errors.has(`estado${indice}`)",
                      },
                    ],
                    staticClass: "v-select-invalid-feedback",
                  },
                  [
                    _vm._v(
                      "\n                    " +
                        _vm._s(_vm.errors.first("estado" + _vm.indice)) +
                        "\n                "
                    ),
                  ]
                ),
              ],
              1
            ),
            _vm._v(" "),
            _c(
              "div",
              { staticClass: "form-group col-12 col-md-6 col-lg-4" },
              [
                _c("label", [_vm._v("Titulação")]),
                _vm._v(" "),
                _c("v-select", {
                  directives: [
                    {
                      name: "validate",
                      rawName: "v-validate",
                      value: { required: true },
                      expression: "{ required: true }",
                    },
                  ],
                  staticClass: "flex-fill",
                  class: [
                    {
                      "v-select-invalid": _vm.errors.has("estado" + _vm.indice),
                    },
                  ],
                  attrs: {
                    options: _vm.estados,
                    "data-vv-as": "estado",
                    selectOnTab: true,
                    disabled: _vm.loading,
                    label: "sigla",
                    name: "estado" + _vm.indice,
                  },
                  on: {
                    input: function ($event) {
                      return _vm.getMunicipios(_vm.indice)
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
                                  "\n                            Nada encontrado com "
                                ),
                                _c("em", [_vm._v(_vm._s(search))]),
                                _vm._v(".\n                        "),
                              ]
                            : _c("em", { staticStyle: { opacity: "0.5" } }, [
                                _vm._v("Começe a digitar algo."),
                              ]),
                        ]
                      },
                    },
                  ]),
                  model: {
                    value: _vm.post.sexo,
                    callback: function ($$v) {
                      _vm.$set(_vm.post, "sexo", $$v)
                    },
                    expression: "post.sexo",
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
                        value: _vm.errors.has("estado" + _vm.indice),
                        expression: "errors.has(`estado${indice}`)",
                      },
                    ],
                    staticClass: "v-select-invalid-feedback",
                  },
                  [
                    _vm._v(
                      "\n                    " +
                        _vm._s(_vm.errors.first("estado" + _vm.indice)) +
                        "\n                "
                    ),
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
          "div",
          { staticClass: "row" },
          [
            _c(
              "div",
              { staticClass: "col-12 d-flex justify-content-between" },
              [
                _c("label", [_vm._v("Endereços")]),
                _vm._v(" "),
                _c(
                  "b-button",
                  {
                    attrs: { size: "sm", variant: "outline-success" },
                    on: {
                      click: function ($event) {
                        return _vm.post.enderecos.push({
                          cep: null,
                          logradouro: null,
                          pais_id: null,
                          municipio: null,
                          municipio_id: null,
                          estado: null,
                          user_id: _vm.post.id,
                          deleted: false,
                        })
                      },
                    },
                  },
                  [_c("i", { staticClass: "fas fa-plus" })]
                ),
              ],
              1
            ),
            _vm._v(" "),
            _vm._l(_vm.post.enderecos, function (endereco, indice) {
              return _c("div", { key: endereco.id, staticClass: "col-12" }, [
                _c("div", { staticClass: "row" }, [
                  _c("div", { staticClass: "col-1" }, [
                    !_vm.selected && _vm.post.enderecos.length > 1
                      ? _c(
                          "span",
                          {
                            directives: [
                              {
                                name: "tooltip",
                                rawName: "v-tooltip.bottom",
                                value: {
                                  content: !_vm.post.enderecos[indice].deleted
                                    ? "Deletar"
                                    : "Restaurar",
                                  delay: 0,
                                  class: "tooltip-custom tooltip-arrow",
                                },
                                expression:
                                  "{\n                                content: !post.enderecos[indice].deleted ? 'Deletar' : 'Restaurar',\n                                delay: 0,\n                                class: 'tooltip-custom tooltip-arrow'\n                            }",
                                modifiers: { bottom: true },
                              },
                            ],
                            staticClass: "btn btn-outline-primary btn-sm mb-3",
                            style: _vm.post.enderecos[indice].deleted
                              ? "opacity: 0.5"
                              : "",
                            on: {
                              click: function ($event) {
                                _vm.post.enderecos[indice].id
                                  ? (_vm.post.enderecos[indice].deleted =
                                      !_vm.post.enderecos[indice].deleted)
                                  : _vm.post.enderecos.splice(indice, 1)
                              },
                            },
                          },
                          [
                            _c("i", {
                              staticClass: "fas",
                              class: {
                                "fa-trash": !_vm.post.enderecos[indice].deleted,
                                "fa-undo": _vm.post.enderecos[indice].deleted,
                              },
                            }),
                          ]
                        )
                      : _vm._e(),
                    _vm._v(" "),
                    _vm.selected && _vm.selected.enderecos.length > 0
                      ? _c(
                          "span",
                          {
                            directives: [
                              {
                                name: "tooltip",
                                rawName: "v-tooltip.bottom",
                                value: {
                                  content: !_vm.post.enderecos[indice].deleted
                                    ? "Deletar"
                                    : "Restaurar",
                                  delay: 0,
                                  class: "tooltip-custom tooltip-arrow",
                                },
                                expression:
                                  "{\n                                content: !post.enderecos[indice].deleted ? 'Deletar' : 'Restaurar',\n                                delay: 0,\n                                class: 'tooltip-custom tooltip-arrow'\n                            }",
                                modifiers: { bottom: true },
                              },
                            ],
                            staticClass: "btn btn-outline-primary btn-sm mb-3",
                            style: _vm.post.enderecos[indice].deleted
                              ? "opacity: 0.5"
                              : "",
                            on: {
                              click: function ($event) {
                                return _vm.verifyEndereco(indice)
                              },
                            },
                          },
                          [
                            _c("i", {
                              staticClass: "fas",
                              class: {
                                "fa-trash": !_vm.post.enderecos[indice].deleted,
                                "fa-undo": _vm.post.enderecos[indice].deleted,
                              },
                            }),
                          ]
                        )
                      : _vm._e(),
                  ]),
                ]),
                _vm._v(" "),
                _c(
                  "div",
                  {
                    staticClass: "row",
                    style: _vm.post.enderecos[indice].deleted
                      ? "opacity: 0.5"
                      : "",
                  },
                  [
                    _c("div", { staticClass: "col-12 col-md-6 col-lg-4" }, [
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
                                value: { min: 9, required: true },
                                expression: "{ min: 9,required: true }",
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
                              { "is-invalid": _vm.errors.has("cep_" + indice) },
                            ],
                            attrs: {
                              size: "sm",
                              name: "cep_" + indice,
                              placeholder: "Digite aqui",
                              "data-vv-as": "CEP",
                              type: "text",
                              disabled: _vm.loading,
                            },
                            on: {
                              change: function ($event) {
                                return _vm.getCep(indice)
                              },
                            },
                            model: {
                              value: _vm.post.enderecos[indice].cep,
                              callback: function ($$v) {
                                _vm.$set(_vm.post.enderecos[indice], "cep", $$v)
                              },
                              expression: "post.enderecos[indice].cep",
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
                                  value: _vm.errors.has("cep_" + indice),
                                  expression: "errors.has(`cep_${indice}`)",
                                },
                              ],
                              staticClass: "invalid-feedback d-block",
                            },
                            [
                              _vm._v(
                                "\n                                " +
                                  _vm._s(_vm.errors.first("cep_" + indice)) +
                                  "\n                            "
                              ),
                            ]
                          ),
                        ],
                        1
                      ),
                    ]),
                    _vm._v(" "),
                    _c("div", { staticClass: "col-12 col-md-6 col-lg-4" }, [
                      _c(
                        "div",
                        { staticClass: "form-group " },
                        [
                          _c("label", { attrs: { for: "" } }, [
                            _vm._v("logradouro"),
                          ]),
                          _vm._v(" "),
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
                              {
                                "is-invalid": _vm.errors.has(
                                  "logradouro_" + indice
                                ),
                              },
                            ],
                            attrs: {
                              size: "sm",
                              name: "logradouro_" + indice,
                              "data-vv-as": "logradouro",
                              type: "text",
                              disabled: _vm.loading,
                            },
                            model: {
                              value: _vm.post.enderecos[indice].logradouro,
                              callback: function ($$v) {
                                _vm.$set(
                                  _vm.post.enderecos[indice],
                                  "logradouro",
                                  $$v
                                )
                              },
                              expression: "post.enderecos[indice].logradouro",
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
                                  value: _vm.errors.has("logradouro_" + indice),
                                  expression:
                                    "errors.has(`logradouro_${indice}`)",
                                },
                              ],
                              staticClass: "invalid-feedback d-block",
                            },
                            [
                              _vm._v(
                                "\n                                " +
                                  _vm._s(
                                    _vm.errors.first("logradouro_" + indice)
                                  ) +
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
                      { staticClass: "form-group col-12 col-md-6 col-lg-4" },
                      [
                        _c("label", [_vm._v("Estado")]),
                        _vm._v(" "),
                        _c("v-select", {
                          directives: [
                            {
                              name: "validate",
                              rawName: "v-validate",
                              value: { required: true },
                              expression: "{ required: true }",
                            },
                          ],
                          staticClass: "flex-fill",
                          class: [
                            {
                              "v-select-invalid": _vm.errors.has(
                                "estado" + indice
                              ),
                            },
                          ],
                          attrs: {
                            options: _vm.estados,
                            "data-vv-as": "estado",
                            selectOnTab: true,
                            disabled: _vm.loading,
                            label: "sigla",
                            name: "estado" + indice,
                          },
                          on: {
                            input: function ($event) {
                              return _vm.getMunicipios(indice)
                            },
                          },
                          scopedSlots: _vm._u(
                            [
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
                            ],
                            null,
                            true
                          ),
                          model: {
                            value: _vm.post.enderecos[indice].estado,
                            callback: function ($$v) {
                              _vm.$set(
                                _vm.post.enderecos[indice],
                                "estado",
                                $$v
                              )
                            },
                            expression: "post.enderecos[indice].estado",
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
                                value: _vm.errors.has("estado" + indice),
                                expression: "errors.has(`estado${indice}`)",
                              },
                            ],
                            staticClass: "v-select-invalid-feedback",
                          },
                          [
                            _vm._v(
                              "\n                            " +
                                _vm._s(_vm.errors.first("estado" + indice)) +
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
                      { staticClass: "form-group col-12 col-md-6 col-lg-4" },
                      [
                        _c("label", [_vm._v("Município")]),
                        _vm._v(" "),
                        _c("v-select", {
                          directives: [
                            {
                              name: "validate",
                              rawName: "v-validate",
                              value: { required: true },
                              expression: "{ required: true }",
                            },
                          ],
                          staticClass: "flex-fill",
                          class: {
                            "v-select-invalid": _vm.errors.has(
                              "municipio" + indice
                            ),
                          },
                          attrs: {
                            name: "municipio" + indice,
                            disabled: _vm.loading,
                            options: _vm.municipios[indice],
                            selectOnTab: false,
                            label: "name",
                            "data-vv-as": "municipio",
                          },
                          model: {
                            value: _vm.post.enderecos[indice].municipio,
                            callback: function ($$v) {
                              _vm.$set(
                                _vm.post.enderecos[indice],
                                "municipio",
                                $$v
                              )
                            },
                            expression: "post.enderecos[indice].municipio",
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
                                value: _vm.errors.has("municipio" + indice),
                                expression: "errors.has(`municipio${indice}`)",
                              },
                            ],
                            staticClass: "v-select-invalid-feedback",
                          },
                          [
                            _vm._v(
                              "\n                            " +
                                _vm._s(_vm.errors.first("municipio" + indice)) +
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
                      { staticClass: "form-group col-12 col-md-6 col-lg-4" },
                      [
                        _c("label", [_vm._v("Pais")]),
                        _vm._v(" "),
                        _c("v-select", {
                          directives: [
                            {
                              name: "validate",
                              rawName: "v-validate",
                              value: { required: true },
                              expression: "{ required: true }",
                            },
                          ],
                          staticClass: "flex-fill",
                          class: [
                            {
                              "v-select-invalid": _vm.errors.has(
                                "pais" + indice
                              ),
                            },
                          ],
                          attrs: {
                            options: _vm.paises,
                            "data-vv-as": "pais",
                            selectOnTab: true,
                            disabled: _vm.loading,
                            label: "sigla",
                            name: "pais" + indice,
                          },
                          on: {
                            input: function ($event) {
                              return _vm.getMunicipios(indice)
                            },
                          },
                          scopedSlots: _vm._u(
                            [
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
                            ],
                            null,
                            true
                          ),
                          model: {
                            value: _vm.post.enderecos[indice].pais,
                            callback: function ($$v) {
                              _vm.$set(_vm.post.enderecos[indice], "pais", $$v)
                            },
                            expression: "post.enderecos[indice].pais",
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
                                value: _vm.errors.has("pais" + indice),
                                expression: "errors.has(`pais${indice}`)",
                              },
                            ],
                            staticClass: "v-select-invalid-feedback",
                          },
                          [
                            _vm._v(
                              "\n                            " +
                                _vm._s(_vm.errors.first("pais" + indice)) +
                                "\n                        "
                            ),
                          ]
                        ),
                      ],
                      1
                    ),
                  ]
                ),
              ])
            }),
          ],
          2
        ),
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
                    [
                      _vm._l(_vm.usersTypes, function (userType, index) {
                        return [
                          _c("input", {
                            directives: [
                              {
                                name: "model",
                                rawName: "v-model",
                                value: _vm.post.todos_tipos_id,
                                expression: "post.todos_tipos_id",
                              },
                            ],
                            key: index,
                            attrs: {
                              disabled: _vm.loading,
                              id: "todos_tipos_" + index,
                              name: "todos_tipos_id",
                              type: "radio",
                            },
                            domProps: {
                              value: userType.id,
                              checked: _vm._q(
                                _vm.post.todos_tipos_id,
                                userType.id
                              ),
                            },
                            on: {
                              change: function ($event) {
                                return _vm.$set(
                                  _vm.post,
                                  "todos_tipos_id",
                                  userType.id
                                )
                              },
                            },
                          }),
                          _c(
                            "label",
                            {
                              key: "label_" + index,
                              attrs: { for: "todos_tipos_" + index },
                            },
                            [_vm._v(_vm._s(userType.descricao))]
                          ),
                        ]
                      }),
                    ],
                    2
                  ),
                ]
              ),
            ]),
          ]),
        ]),
        _vm._v(" "),
        _vm.post.todos_tipos_id != 1
          ? _c("div", { staticClass: "row" }, [
              _c("div", { staticClass: "col-12" }, [
                _c("label", { attrs: { for: "ativo" } }, [
                  _vm._v("Acessos Permitidos:"),
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