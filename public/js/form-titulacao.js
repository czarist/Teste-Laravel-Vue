"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["form-titulacao"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/config/titulacao/FormTitulacao.vue?vue&type=script&lang=js&":
/*!*************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/config/titulacao/FormTitulacao.vue?vue&type=script&lang=js& ***!
  \*************************************************************************************************************************************************************************************************************************************/
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

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ['selected', 'id'],
  mixins: [_mixins_global_mixins__WEBPACK_IMPORTED_MODULE_0__["default"]],
  data: function data() {
    return {
      loading: false,
      post: {
        id: null,
        titulacao: null,
        _method: 'post'
      }
    };
  },
  watch: {
    selected: function selected() {
      if (this.selected) {
        this.post.id = this.selected.id;
        this.post.titulacao = this.selected.titulacao;
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
      var _this = this;

      this.$validator.validate().then(function (valid) {
        if (valid) {
          _this.message('Aguarde...', 'Estamos salvando suas informações', 'info', -1);

          _this.loading = true;
          axios.post("".concat("", "/config/titulacao").concat(_this.url), _this.post).then(function (res) {
            _this.clear();

            if (res.status == 201) {
              _this.loading = false;

              _this.$emit('store', res.data.response);
            } else {
              _this.loading = false;

              _this.$emit('update', res.data.response);
            }

            _this.message('Sucesso', res.status == 201 ? 'Registro cadastrado.' : 'Registro atualizado.', 'success');
          })["catch"](function (error) {
            if (error.response.status == 422) {
              if (error.response.data.message == "The given data was invalid.") {
                _this.loading = false;
                return _this.message('Campos Obrigatórios', 'Preencha todos os campos obrigatórios', 'error');
              }
            }

            if (error.response.status == 400) {
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
        } else {
          _this.message('Campos Obrigatórios', 'Preencha todos os campos obrigatórios', 'error');
        }
      });
    },
    clear: function clear() {
      this.post.id = null;
      this.post.tipo_titulacao = null;
      this.post._method = 'post';
      this.$validator.reset('tipo_titulacao');
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

/***/ "./resources/js/components/config/titulacao/FormTitulacao.vue":
/*!********************************************************************!*\
  !*** ./resources/js/components/config/titulacao/FormTitulacao.vue ***!
  \********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _FormTitulacao_vue_vue_type_template_id_7372bcf7___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./FormTitulacao.vue?vue&type=template&id=7372bcf7& */ "./resources/js/components/config/titulacao/FormTitulacao.vue?vue&type=template&id=7372bcf7&");
/* harmony import */ var _FormTitulacao_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./FormTitulacao.vue?vue&type=script&lang=js& */ "./resources/js/components/config/titulacao/FormTitulacao.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _FormTitulacao_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _FormTitulacao_vue_vue_type_template_id_7372bcf7___WEBPACK_IMPORTED_MODULE_0__.render,
  _FormTitulacao_vue_vue_type_template_id_7372bcf7___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/config/titulacao/FormTitulacao.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/config/titulacao/FormTitulacao.vue?vue&type=script&lang=js&":
/*!*********************************************************************************************!*\
  !*** ./resources/js/components/config/titulacao/FormTitulacao.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_FormTitulacao_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./FormTitulacao.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/config/titulacao/FormTitulacao.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_FormTitulacao_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/config/titulacao/FormTitulacao.vue?vue&type=template&id=7372bcf7&":
/*!***************************************************************************************************!*\
  !*** ./resources/js/components/config/titulacao/FormTitulacao.vue?vue&type=template&id=7372bcf7& ***!
  \***************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_FormTitulacao_vue_vue_type_template_id_7372bcf7___WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   "staticRenderFns": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_FormTitulacao_vue_vue_type_template_id_7372bcf7___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_FormTitulacao_vue_vue_type_template_id_7372bcf7___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./FormTitulacao.vue?vue&type=template&id=7372bcf7& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/config/titulacao/FormTitulacao.vue?vue&type=template&id=7372bcf7&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/config/titulacao/FormTitulacao.vue?vue&type=template&id=7372bcf7&":
/*!******************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/config/titulacao/FormTitulacao.vue?vue&type=template&id=7372bcf7& ***!
  \******************************************************************************************************************************************************************************************************************************************/
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
      attrs: { id: "titulacaoModal", "no-close-on-backdrop": "" },
      scopedSlots: _vm._u([
        {
          key: "modal-header",
          fn: function (ref) {
            var close = ref.close
            return [
              _vm.post.id
                ? _c("h5", [_vm._v("Editar titulacao")])
                : _c("h5", [_vm._v("Cadastrar titulacao")]),
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
          "b-form-group",
          { attrs: { label: "Titulacao", "label-class": "font-weight-bold" } },
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
                { "is-invalid": _vm.errors.has("titulacao") },
              ],
              attrs: {
                name: "titulacao",
                size: "sm",
                type: "text",
                "aria-describedby": "input-1-live-feedback",
                "data-vv-as": "titulação",
                disabled: _vm.loading,
              },
              model: {
                value: _vm.post.titulacao,
                callback: function ($$v) {
                  _vm.$set(_vm.post, "titulacao", $$v)
                },
                expression: "post.titulacao",
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
                    value: _vm.errors.has("titulacao"),
                    expression: "errors.has(`titulacao`)",
                  },
                ],
                staticClass: "invalid-feedback",
              },
              [
                _vm._v(
                  "\n                " +
                    _vm._s(_vm.errors.first("titulacao")) +
                    "\n            "
                ),
              ]
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