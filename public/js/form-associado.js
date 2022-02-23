"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["form-associado"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/admin/associado/FormAssociado.vue?vue&type=script&lang=js&":
/*!************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/admin/associado/FormAssociado.vue?vue&type=script&lang=js& ***!
  \************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _mixins_global_mixins__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../mixins/global-mixins */ "./resources/js/components/mixins/global-mixins.js");
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  mixins: [_mixins_global_mixins__WEBPACK_IMPORTED_MODULE_0__["default"]],
  data: function data() {
    return {
      instituicoes: [],
      titulacoes: [],
      loading: false,
      post: {
        id: null,
        numero_socio: null,
        anuidade: null,
        divisao_tematica: null,
        obs_isentamos: null,
        instituicao_id: null,
        titulacao_id: null,
        _method: 'post'
      }
    };
  },
  mounted: function mounted() {
    var _this = this;

    axios.get("".concat("", "/get/instituicoes")).then(function (res) {
      _this.instituicoes = res.data;
    });
    axios.get("".concat("", "/get/titulacoes")).then(function (res) {
      _this.titulacoes = res.data;
    });
  },
  watch: {
    selected: function selected() {
      if (this.selected) {
        this.post.id = this.selected.id;
        this.post.numero_socio = this.selected.numero_socio;
        this.post.anuidade = this.selected.anuidade;
        this.post.divisao_tematica = this.selected.divisao_tematica;
        this.post.instituicao_id = this.selected.instituicao_id;
        this.post.titulacao_id = this.selected.titulacao_id;
        this.post.obs_isentamos = this.selected.obs_isentamos;
        this.post._method = 'put';
      } else {
        this.clear();
      }
    }
  },
  computed: {
    url: function url() {
      return this.post && this.post.id ? "/".concat(this.post.id) : '';
    }
  },
  methods: {
    save: function save() {
      var _this2 = this;

      this.$validator.validate().then(function (valid) {
        if (valid) {
          _this2.message('Aguarde...', 'Estamos salvando suas informações', 'info', -1);

          _this2.loading = true;
          axios.post("".concat("", "/admin/associado").concat(_this2.url), _this2.post).then(function (res) {
            _this2.clear();

            if (res.status == 201) {
              _this2.loading = false;

              _this2.$emit('store', res.data.response);
            } else {
              _this2.loading = false;

              _this2.$emit('update', res.data.response);
            }

            _this2.message('Sucesso', res.status == 201 ? 'Registro cadastrado.' : 'Registro atualizado.', 'success');
          })["catch"](function (error) {
            if (error.response.status == 422) {
              if (error.response.data.message == "The given data was invalid.") {
                _this2.loading = false;
                return _this2.message('Campos Obrigatórios', 'Preencha todos os campos obrigatórios', 'error');
              }
            }

            if (error.response.status == 400) {
              _this2.loading = false;

              _this2.message('Erro', 'Por favor tente novamente.', 'error');
            }

            if (error.response.status == 403) {
              if (error.response.data.message == "This action is unauthorized.") {
                _this2.loading = false;

                _this2.message('Erro', 'Ação não autorizada.', 'error');
              }
            }
          });
        } else {
          _this2.message('Campos Obrigatórios', 'Preencha todos os campos obrigatórios', 'error');
        }
      });
    },
    clear: function clear() {
      this.post.id = null;
      this.post.numero_socio = null;
      this.post.anuidade = null;
      this.post.divisao_tematica = null;
      this.post.instituicao_id = null;
      this.post.titulacao_id = null;
      this.post._method = 'post';
      this.$validator.reset('numero_socio');
      this.$validator.reset('associado');
      this.$validator.reset('anuidade');
      this.$validator.reset('divisao_tematica');
      this.$validator.reset('titulacao');
      this.$validator.reset('instituicao');
    }
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

/***/ "./resources/js/components/admin/associado/FormAssociado.vue":
/*!*******************************************************************!*\
  !*** ./resources/js/components/admin/associado/FormAssociado.vue ***!
  \*******************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _FormAssociado_vue_vue_type_template_id_7ad82ebc___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./FormAssociado.vue?vue&type=template&id=7ad82ebc& */ "./resources/js/components/admin/associado/FormAssociado.vue?vue&type=template&id=7ad82ebc&");
/* harmony import */ var _FormAssociado_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./FormAssociado.vue?vue&type=script&lang=js& */ "./resources/js/components/admin/associado/FormAssociado.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _FormAssociado_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _FormAssociado_vue_vue_type_template_id_7ad82ebc___WEBPACK_IMPORTED_MODULE_0__.render,
  _FormAssociado_vue_vue_type_template_id_7ad82ebc___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/admin/associado/FormAssociado.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/admin/associado/FormAssociado.vue?vue&type=script&lang=js&":
/*!********************************************************************************************!*\
  !*** ./resources/js/components/admin/associado/FormAssociado.vue?vue&type=script&lang=js& ***!
  \********************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_FormAssociado_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./FormAssociado.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/admin/associado/FormAssociado.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_FormAssociado_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/admin/associado/FormAssociado.vue?vue&type=template&id=7ad82ebc&":
/*!**************************************************************************************************!*\
  !*** ./resources/js/components/admin/associado/FormAssociado.vue?vue&type=template&id=7ad82ebc& ***!
  \**************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_FormAssociado_vue_vue_type_template_id_7ad82ebc___WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   "staticRenderFns": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_FormAssociado_vue_vue_type_template_id_7ad82ebc___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_FormAssociado_vue_vue_type_template_id_7ad82ebc___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./FormAssociado.vue?vue&type=template&id=7ad82ebc& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/admin/associado/FormAssociado.vue?vue&type=template&id=7ad82ebc&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/admin/associado/FormAssociado.vue?vue&type=template&id=7ad82ebc&":
/*!*****************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/admin/associado/FormAssociado.vue?vue&type=template&id=7ad82ebc& ***!
  \*****************************************************************************************************************************************************************************************************************************************/
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
      attrs: { id: "associadoModal", "no-close-on-backdrop": "" },
      scopedSlots: _vm._u([
        {
          key: "modal-header",
          fn: function (ref) {
            var close = ref.close
            return [
              _vm.post.id
                ? _c("h5", [_vm._v("Editar associado")])
                : _c("h5", [_vm._v("Cadastrar associado")]),
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
                    size: "md",
                    variant: "outline-success",
                    disabled: _vm.loading,
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
                    attrs: {
                      label: "Número sócio",
                      "label-class": "font-weight-bold",
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
                            numeroSocioCheck: _vm.post.id,
                          },
                          expression:
                            "{ required: true,  numeroSocioCheck: post.id }",
                        },
                      ],
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
                        "data-vv-as": "número sócio",
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
                      label: "Anuidade",
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
                        { "is-invalid": _vm.errors.has("anuidade") },
                      ],
                      attrs: {
                        name: "anuidade",
                        size: "sm",
                        disabled: _vm.loading,
                        type: "date",
                        "aria-describedby": "input-1-live-feedback",
                        "data-vv-as": "Anuidade",
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
                      label: "Instituição",
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
                            value: { required: true },
                            expression: "{ required: true }",
                          },
                        ],
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
              { attrs: { cols: "12", sm: "6", lg: "4" } },
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
                      label: "Divisão temática",
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
                        { "is-invalid": _vm.errors.has("divisao_tematica") },
                      ],
                      attrs: {
                        name: "divisao_tematica",
                        size: "sm",
                        disabled: _vm.loading,
                        type: "text",
                        "aria-describedby": "input-1-live-feedback",
                        "data-vv-as": "Divisão temática",
                      },
                      model: {
                        value: _vm.post.divisao_tematica,
                        callback: function ($$v) {
                          _vm.$set(_vm.post, "divisao_tematica", $$v)
                        },
                        expression: "post.divisao_tematica",
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
                            value: _vm.errors.has("divisao_tematica"),
                            expression: "errors.has(`divisao_tematica`)",
                          },
                        ],
                        staticClass: "invalid-feedback",
                      },
                      [
                        _vm._v(
                          "\n                        " +
                            _vm._s(_vm.errors.first("divisao_tematica")) +
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
                        disabled: _vm.loading,
                        type: "text",
                        "aria-describedby": "input-1-live-feedback",
                      },
                      model: {
                        value: _vm.post.obs_isentamos,
                        callback: function ($$v) {
                          _vm.$set(_vm.post, "obs_isentamos", $$v)
                        },
                        expression: "post.obs_isentamos",
                      },
                    }),
                  ],
                  1
                ),
              ],
              1
            ),
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



/***/ })

}]);