<template>
    <div class="mt-4">
        <h5 class="col-12 d-flex justify-content-between">
            Certificados
        </h5>
        <div class="col-12">
            <!-- CERTIFICADOS PRESENÇA -->
            <div                                 
                v-if="user && user.regional_centrooeste && user.regional_centrooeste.presenca == 1
                    || user && user.regional_nordeste && user.regional_nordeste.presenca == 1
                    || user && user.regional_norte && user.regional_norte.presenca == 1
                    || user && user.regional_sul && user.regional_sul.presenca == 1
                    || user && user.regional_suldeste && user.regional_suldeste.presenca == 1
                    || user && user.nacional && user.nacional.presenca == 1
                "
            >
                <div class="card">
                    <div class="card-header">
                        Certificado de Presença
                    </div>

                    <div class="card-body pb-2">
                        <div class="row">
                            <div 
                                class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 layout-spacing"
                                v-if="user && user.regional_nordeste && user.regional_nordeste.presenca == 1"
                            >
                                <div class="widget widget-account-invoice-two">
                                    <div class="widget-content">
                                        <div class="account-box">
                                            <div class="info">
                                                <div class="inv-title">
                                                    <h4 class="" style="color:#FFF;">Regional Nordeste</h4>
                                                </div>
                                                <div class="inv-balance-info">
                                                </div>
                                            </div>
                                            <div class="acc-action">
                                                <button
                                                    v-if="user && user.regional_nordeste && user.regional_nordeste.presenca == 1"
                                                    v-tooltip.bottom="{
                                                        content: 'Certificado de Presença Regional Nordeste',
                                                        delay: 0,
                                                        class: 'tooltip-custom tooltip-arrow'
                                                    }"
                                                    title="Certificado de Presença Regional Nordeste"
                                                    class="btn btn-info btn-sm m-1 text-white"
                                                    :disabled="loading"
                                                    @click="certificado_presenca(user.id, user.regional_nordeste.regiao, user.regional_nordeste.id)"
                                                >
                                                    Baixar
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div 
                                class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 layout-spacing"
                                v-if="user && user.regional_norte && user.regional_norte.presenca == 1"
                            >
                                <div class="widget widget-account-invoice-two">
                                    <div class="widget-content">
                                        <div class="account-box">
                                            <div class="info">
                                                <div class="inv-title">
                                                    <h4 class="" style="color:#FFF;">Regional Norte</h4>
                                                </div>
                                                <div class="inv-balance-info">
                                                </div>
                                            </div>
                                            <div class="acc-action">
                                                <button
                                                    v-if="user && user.regional_norte && user.regional_norte.presenca == 1"
                                                    v-tooltip.bottom="{
                                                    content: 'Certificado de Presença Regional Norte',
                                                    delay: 0,
                                                    class: 'tooltip-custom tooltip-arrow'
                                                    }"
                                                    title="Certificado de Presença Regional Norte"
                                                    class="btn btn-info btn-sm m-1 text-white"
                                                    :disabled="loading"
                                                    @click="certificado_presenca(user.id, user.regional_norte.regiao, user.regional_norte.id)"
                                                    >
                                                    Baixar
                                                </button>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div 
                                class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 layout-spacing"
                                v-if="user && user.regional_suldeste && user.regional_suldeste.presenca == 1"
                            >
                                <div class="widget widget-account-invoice-two">
                                    <div class="widget-content">
                                        <div class="account-box">
                                            <div class="info">
                                                <div class="inv-title">
                                                    <h4 class="" style="color:#FFF;">Regional Sudeste</h4>
                                                </div>
                                                <div class="inv-balance-info">
                                                </div>
                                            </div>
                                            <div class="acc-action">
                                                <button
                                                    v-if="user && user.regional_suldeste && user.regional_suldeste.presenca == 1"
                                                    v-tooltip.bottom="{
                                                    content: 'Certificado de Presença Regional Sudeste',
                                                    delay: 0,
                                                    class: 'tooltip-custom tooltip-arrow'
                                                    }"
                                                    title="Certificado de Presença Regional Sudeste"
                                                    class="btn btn-info btn-sm m-1 text-white"
                                                    :disabled="loading"
                                                    @click="certificado_presenca(user.id, user.regional_suldeste.regiao, user.regional_suldeste.id)"
                                                    >
                                                    Baixar
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div 
                                class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 layout-spacing"
                                v-if="user && user.regional_centrooeste && user.regional_centrooeste.presenca == 1"
                            >
                                <div class="widget widget-account-invoice-two">
                                    <div class="widget-content">
                                        <div class="account-box">
                                            <div class="info">
                                                <div class="inv-title">
                                                    <h4 class="" style="color:#FFF;">Regional Centro Oeste</h4>
                                                </div>
                                                <div class="inv-balance-info">
                                                </div>
                                            </div>
                                            <div class="acc-action">
                                                <button
                                                    v-if="user && user.regional_centrooeste && user.regional_centrooeste.presenca == 1"
                                                    v-tooltip.bottom="{
                                                    content: 'Certificado de Presença Regional Centro Oeste',
                                                    delay: 0,
                                                    class: 'tooltip-custom tooltip-arrow'
                                                    }"
                                                    title="Certificado de Presença Regional Centro Oeste"
                                                    class="btn btn-info btn-sm m-1 text-white"
                                                    :disabled="loading"
                                                    @click="certificado_presenca(user.id, user.regional_centrooeste.regiao, user.regional_centrooeste.id)"
                                                    >
                                                    Baixar
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div 
                                class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 layout-spacing"
                                v-if="user && user.regional_sul && user.regional_sul.presenca == 1"
                            >
                                <div class="widget widget-account-invoice-two">
                                    <div class="widget-content">
                                        <div class="account-box">
                                            <div class="info">
                                                <div class="inv-title">
                                                    <h4 class="" style="color:#FFF;">Regional Sul</h4>
                                                </div>
                                                <div class="inv-balance-info">
                                                </div>
                                            </div>
                                            <div class="acc-action">
                                                <button
                                                    v-if="user && user.regional_sul && user.regional_sul.presenca == 1"
                                                    v-tooltip.bottom="{
                                                    content: 'Certificado de Presença Regional Sul',
                                                    delay: 0,
                                                    class: 'tooltip-custom tooltip-arrow'
                                                    }"
                                                    title="Certificado de Presença Regional Sul"
                                                    class="btn btn-info btn-sm m-1 text-white"
                                                    :disabled="loading"
                                                    @click="certificado_presenca(user.id, user.regional_sul.regiao, user.regional_sul.id)"
                                                    >
                                                    Baixar
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <hr>

            <!-- CERTIFICADOS APRESENTAÇÃO DT -->
            <div 
                v-if="
                    user && user.regional_nordeste && user.regional_nordeste.submissao_dt && user.regional_nordeste.submissao_dt.apresentacao == 1 && user.regional_nordeste.presenca == 1
                || user && user.regional_nordeste && user.regional_nordeste.submissao_junior && user.regional_nordeste.submissao_junior.apresentacao == 1 && user.regional_nordeste.presenca == 1
                || user && user.regional_nordeste && user.regional_nordeste.submissao_mesa && user.regional_nordeste.submissao_mesa.apresentacao == 1 && user.regional_nordeste.presenca == 1
                
                || user && user.regional_suldeste && user.regional_suldeste.submissao_dt && user.regional_suldeste.submissao_dt.apresentacao == 1 && user.regional_suldeste.presenca == 1
                || user && user.regional_suldeste && user.regional_suldeste.submissao_junior && user.regional_suldeste.submissao_junior.apresentacao == 1 && user.regional_suldeste.presenca == 1
                || user && user.regional_suldeste && user.regional_suldeste.submissao_mesa && user.regional_suldeste.submissao_mesa.apresentacao == 1 && user.regional_suldeste.presenca == 1

                || user && user.regional_norte && user.regional_norte.submissao_dt && user.regional_norte.submissao_dt.apresentacao == 1 && user.regional_norte.presenca == 1
                || user && user.regional_norte && user.regional_norte.submissao_junior && user.regional_norte.submissao_junior.apresentacao == 1 && user.regional_norte.presenca == 1
                || user && user.regional_norte && user.regional_norte.submissao_mesa && user.regional_norte.submissao_mesa.apresentacao == 1 && user.regional_norte.presenca == 1

                || user && user.regional_centrooeste && user.regional_centrooeste.submissao_dt && user.regional_centrooeste.submissao_dt.apresentacao == 1 && user.regional_centrooeste.presenca == 1
                || user && user.regional_centrooeste && user.regional_centrooeste.submissao_junior && user.regional_centrooeste.submissao_junior.apresentacao == 1 && user.regional_centrooeste.presenca == 1
                || user && user.regional_centrooeste && user.regional_centrooeste.submissao_mesa && user.regional_centrooeste.submissao_mesa.apresentacao == 1 && user.regional_centrooeste.presenca == 1

                || user && user.regional_sul && user.regional_sul.submissao_dt && user.regional_sul.submissao_dt.apresentacao == 1 && user.regional_sul.presenca == 1
                || user && user.regional_sul && user.regional_sul.submissao_junior && user.regional_sul.submissao_junior.apresentacao == 1 && user.regional_sul.presenca == 1
                || user && user.regional_sul && user.regional_sul.submissao_mesa && user.regional_sul.submissao_mesa.apresentacao == 1 && user.regional_sul.presenca == 1

                ||  user && user.is_coautor_norte_2022 
                ||  user && user.is_coautor_nordeste_2022
                ||  user && user.is_coautor_sudeste_2022 
                ||  user && user.is_coautor_sul_2022
                ||  user && user.is_coautor_centrooeste_2022


                "
            >
                <div class="card">
                    <div class="card-header">Certificado de Apresentação de trabalho - DT, MESA E IJ</div>
                    <div class="card-body pb-2">
                        <!-- DT -->
                        <div class="row">
                            <div 
                                class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 layout-spacing"
                                v-if="user && user.regional_nordeste && user.regional_nordeste.submissao_dt && user.regional_nordeste.submissao_dt.apresentacao == 1 ||
                                    user && user.regional_nordeste && user.regional_nordeste.submissao_junior && user.regional_nordeste.submissao_junior.apresentacao == 1 ||
                                    user && user.regional_nordeste && user.regional_nordeste.submissao_mesa && user.regional_nordeste.submissao_mesa.apresentacao == 1                                                       
                                    && user.regional_nordeste.presenca == 1"
                            >
                                <div class="widget widget-account-invoice-two">
                                    <div class="widget-content">
                                        <div class="account-box">
                                            <div class="info">
                                                <div class="inv-title">
                                                    <h4 class="" style="color:#FFF;">Regional Nordeste</h4>
                                                </div>
                                                <div class="inv-balance-info">
                                                </div>
                                            </div>
                                            <div class="acc-action">
                                                <button
                                                    v-if="user && user.regional_nordeste && user.regional_nordeste.submissao_dt && user.regional_nordeste.submissao_dt.apresentacao == 1 ||
                                                        user && user.regional_nordeste && user.regional_nordeste.submissao_junior && user.regional_nordeste.submissao_junior.apresentacao == 1 ||
                                                        user && user.regional_nordeste && user.regional_nordeste.submissao_mesa && user.regional_nordeste.submissao_mesa.apresentacao == 1                                                       
                                                        && user.regional_nordeste.presenca == 1"
                                                    v-tooltip.bottom="{
                                                    content: 'Certificado de Apresentação de trabalho',
                                                    delay: 0,
                                                    class: 'tooltip-custom tooltip-arrow'
                                                    }"
                                                    title="Certificado de Apresentação de trabalho"
                                                    class="btn btn-info btn-sm m-1 text-white"
                                                    :disabled="loading"
                                                    @click="certificado_apresentacao(user.id, user.regional_nordeste.regiao, user.regional_nordeste.id)"
                                                    >
                                                    Baixar
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div 
                                class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 layout-spacing"
                                v-if="user && user.regional_suldeste && user.regional_suldeste.submissao_dt && user.regional_suldeste.submissao_dt.apresentacao == 1 ||
                                    user && user.regional_suldeste && user.regional_suldeste.submissao_junior && user.regional_suldeste.submissao_junior.apresentacao == 1 ||
                                    user && user.regional_suldeste && user.regional_suldeste.submissao_mesa && user.regional_suldeste.submissao_mesa.apresentacao == 1                                                       
                                    && user.regional_suldeste.presenca == 1"
                            >
                                <div class="widget widget-account-invoice-two">
                                    <div class="widget-content">
                                        <div class="account-box">
                                            <div class="info">
                                                <div class="inv-title">
                                                    <h4 class="" style="color:#FFF;">Regional Sudeste</h4>
                                                </div>
                                                <div class="inv-balance-info">
                                                </div>
                                            </div>
                                            <div class="acc-action">
                                                <button
                                                    v-if="user && user.regional_suldeste && user.regional_suldeste.submissao_dt && user.regional_suldeste.submissao_dt.apresentacao == 1 ||
                                                        user && user.regional_suldeste && user.regional_suldeste.submissao_junior && user.regional_suldeste.submissao_junior.apresentacao == 1 ||
                                                        user && user.regional_suldeste && user.regional_suldeste.submissao_mesa && user.regional_suldeste.submissao_mesa.apresentacao == 1                                                       
                                                        && user.regional_suldeste.presenca == 1"
                                                    v-tooltip.bottom="{
                                                    content: 'Certificado de Apresentação de trabalho',
                                                    delay: 0,
                                                    class: 'tooltip-custom tooltip-arrow'
                                                    }"
                                                    title="Certificado de Apresentação de trabalho"
                                                    class="btn btn-info btn-sm m-1 text-white"
                                                    :disabled="loading"
                                                    @click="certificado_apresentacao(user.id, user.regional_suldeste.regiao, user.regional_suldeste.id)"
                                                    >
                                                    Baixar
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div 
                                class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 layout-spacing"
                                v-if="user && user.regional_norte && user.regional_norte.submissao_dt && user.regional_norte.submissao_dt.apresentacao == 1 ||
                                    user && user.regional_norte && user.regional_norte.submissao_junior && user.regional_norte.submissao_junior.apresentacao == 1 ||
                                    user && user.regional_norte && user.regional_norte.submissao_mesa && user.regional_norte.submissao_mesa.apresentacao == 1                                                       
                                    && user.regional_norte.presenca == 1"
                            >
                                <div class="widget widget-account-invoice-two">
                                    <div class="widget-content">
                                        <div class="account-box">
                                            <div class="info">
                                                <div class="inv-title">
                                                    <h4 class="" style="color:#FFF;">Regional Norte</h4>
                                                </div>
                                                <div class="inv-balance-info">
                                                </div>
                                            </div>
                                            <div class="acc-action">
                                                <button
                                                    v-if="user && user.regional_norte && user.regional_norte.submissao_dt && user.regional_norte.submissao_dt.apresentacao == 1 ||
                                                        user && user.regional_norte && user.regional_norte.submissao_junior && user.regional_norte.submissao_junior.apresentacao == 1 ||
                                                        user && user.regional_norte && user.regional_norte.submissao_mesa && user.regional_norte.submissao_mesa.apresentacao == 1                                                       
                                                        && user.regional_norte.presenca == 1"
                                                    v-tooltip.bottom="{
                                                    content: 'Certificado de Apresentação de trabalho',
                                                    delay: 0,
                                                    class: 'tooltip-custom tooltip-arrow'
                                                    }"
                                                    title="Certificado de Apresentação de trabalho"
                                                    class="btn btn-info btn-sm m-1 text-white"
                                                    :disabled="loading"
                                                    @click="certificado_apresentacao(user.id, user.regional_norte.regiao, user.regional_norte.id)"
                                                    >
                                                    Baixar
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div 
                                class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 layout-spacing"
                                v-if="user && user.regional_sul && user.regional_sul.submissao_dt && user.regional_sul.submissao_dt.apresentacao == 1 ||
                                    user && user.regional_sul && user.regional_sul.submissao_junior && user.regional_sul.submissao_junior.apresentacao == 1 ||
                                    user && user.regional_sul && user.regional_sul.submissao_mesa && user.regional_sul.submissao_mesa.apresentacao == 1                                                       
                                    && user.regional_sul.presenca == 1"
                            >
                                <div class="widget widget-account-invoice-two">
                                    <div class="widget-content">
                                        <div class="account-box">
                                            <div class="info">
                                                <div class="inv-title">
                                                    <h4 class="" style="color:#FFF;">Regional Sul</h4>
                                                </div>
                                                <div class="inv-balance-info">
                                                </div>
                                            </div>
                                            <div class="acc-action">
                                                <button
                                                    v-if="user && user.regional_sul && user.regional_sul.submissao_dt && user.regional_sul.submissao_dt.apresentacao == 1 ||
                                                        user && user.regional_sul && user.regional_sul.submissao_junior && user.regional_sul.submissao_junior.apresentacao == 1 ||
                                                        user && user.regional_sul && user.regional_sul.submissao_mesa && user.regional_sul.submissao_mesa.apresentacao == 1                                                       
                                                        && user.regional_sul.presenca == 1"
                                                    v-tooltip.bottom="{
                                                    content: 'Certificado de Apresentação de trabalho',
                                                    delay: 0,
                                                    class: 'tooltip-custom tooltip-arrow'
                                                    }"
                                                    title="Certificado de Apresentação de trabalho"
                                                    class="btn btn-info btn-sm m-1 text-white"
                                                    :disabled="loading"
                                                    @click="certificado_apresentacao(user.id, user.regional_sul.regiao, user.regional_sul.id)"
                                                    >
                                                    Baixar
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div 
                                class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 layout-spacing"
                                v-if="user && user.regional_centrooeste && user.regional_centrooeste.submissao_dt && user.regional_centrooeste.submissao_dt.apresentacao == 1 ||
                                    user && user.regional_centrooeste && user.regional_centrooeste.submissao_junior && user.regional_centrooeste.submissao_junior.apresentacao == 1 ||
                                    user && user.regional_centrooeste && user.regional_centrooeste.submissao_mesa && user.regional_centrooeste.submissao_mesa.apresentacao == 1                                                       
                                    && user.regional_centrooeste.presenca == 1"
                            >
                                <div class="widget widget-account-invoice-two">
                                    <div class="widget-content">
                                        <div class="account-box">
                                            <div class="info">
                                                <div class="inv-title">
                                                    <h4 class="" style="color:#FFF;">Regional Sul</h4>
                                                </div>
                                                <div class="inv-balance-info">
                                                </div>
                                            </div>
                                            <div class="acc-action">
                                                <button
                                                    v-if="user && user.regional_centrooeste && user.regional_centrooeste.submissao_dt && user.regional_centrooeste.submissao_dt.apresentacao == 1 ||
                                                        user && user.regional_centrooeste && user.regional_centrooeste.submissao_junior && user.regional_centrooeste.submissao_junior.apresentacao == 1 ||
                                                        user && user.regional_centrooeste && user.regional_centrooeste.submissao_mesa && user.regional_centrooeste.submissao_mesa.apresentacao == 1                                                       
                                                        && user.regional_centrooeste.presenca == 1"
                                                    v-tooltip.bottom="{
                                                    content: 'Certificado de Apresentação de trabalho',
                                                    delay: 0,
                                                    class: 'tooltip-custom tooltip-arrow'
                                                    }"
                                                    title="Certificado de Apresentação de trabalho"
                                                    class="btn btn-info btn-sm m-1 text-white"
                                                    :disabled="loading"
                                                    @click="certificado_apresentacao(user.id, user.regional_centrooeste.regiao, user.regional_centrooeste.id)"
                                                    >
                                                    Baixar
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- DT - COAUTOR -->
                        <div class="row">
                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 layout-spacing" v-if="user && user.is_coautor_norte_2022">
                                <div class="widget widget-account-invoice-two">
                                    <div class="widget-content">
                                        <div class="account-box">
                                            <div class="info">
                                                <div class="inv-title">
                                                    <h4 class="" style="color:#FFF;">Regional Norte - Coautor</h4>
                                                </div>
                                                <div class="inv-balance-info">
                                                </div>
                                            </div>
                                            <div class="acc-action">
                                                <button
                                                    v-if="user && user.is_coautor_norte_2022"
                                                    v-tooltip.bottom="{
                                                    content: 'Certificado de Apresentação de trabalho',
                                                    delay: 0,
                                                    class: 'tooltip-custom tooltip-arrow'
                                                    }"
                                                    title="Certificado de Apresentação de trabalho"
                                                    class="btn btn-info btn-sm m-1 text-white"
                                                    :disabled="loading"
                                                    @click="certificado_apresentacao_coautor(user.id, 'norte')"
                                                    >
                                                    Baixar
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 layout-spacing" v-if="user && user.is_coautor_nordeste_2022">
                                <div class="widget widget-account-invoice-two">
                                    <div class="widget-content">
                                        <div class="account-box">
                                            <div class="info">
                                                <div class="inv-title">
                                                    <h4 class="" style="color:#FFF;">Regional Nordeste - Coautor</h4>
                                                </div>
                                                <div class="inv-balance-info">
                                                </div>
                                            </div>
                                            <div class="acc-action">
                                                <button
                                                    v-if="user && user.is_coautor_nordeste_2022"
                                                    v-tooltip.bottom="{
                                                    content: 'Certificado de Apresentação de trabalho',
                                                    delay: 0,
                                                    class: 'tooltip-custom tooltip-arrow'
                                                    }"
                                                    title="Certificado de Apresentação de trabalho"
                                                    class="btn btn-info btn-sm m-1 text-white"
                                                    :disabled="loading"
                                                    @click="certificado_apresentacao_coautor(user.id, 'nordeste')"
                                                    >
                                                    Baixar
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 layout-spacing" v-if="user && user.is_coautor_sudeste_2022">
                                <div class="widget widget-account-invoice-two">
                                    <div class="widget-content">
                                        <div class="account-box">
                                            <div class="info">
                                                <div class="inv-title">
                                                    <h4 class="" style="color:#FFF;">Regional Sudeste - Coautor</h4>
                                                </div>
                                                <div class="inv-balance-info">
                                                </div>
                                            </div>
                                            <div class="acc-action">
                                                <button
                                                    v-if="user && user.is_coautor_sudeste_2022"
                                                    v-tooltip.bottom="{
                                                    content: 'Certificado de Apresentação de trabalho',
                                                    delay: 0,
                                                    class: 'tooltip-custom tooltip-arrow'
                                                    }"
                                                    title="Certificado de Apresentação de trabalho"
                                                    class="btn btn-info btn-sm m-1 text-white"
                                                    :disabled="loading"
                                                    @click="certificado_apresentacao_coautor(user.id, 'sudeste')"
                                                    >
                                                    Baixar
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 layout-spacing" v-if="user && user.is_coautor_sul_2022">
                                <div class="widget widget-account-invoice-two">
                                    <div class="widget-content">
                                        <div class="account-box">
                                            <div class="info">
                                                <div class="inv-title">
                                                    <h4 class="" style="color:#FFF;">Regional Sul - Coautor</h4>
                                                </div>
                                                <div class="inv-balance-info">
                                                </div>
                                            </div>
                                            <div class="acc-action">
                                                <button
                                                    v-if="user && user.is_coautor_sul_2022"
                                                    v-tooltip.bottom="{
                                                    content: 'Certificado de Apresentação de trabalho',
                                                    delay: 0,
                                                    class: 'tooltip-custom tooltip-arrow'
                                                    }"
                                                    title="Certificado de Apresentação de trabalho"
                                                    class="btn btn-info btn-sm m-1 text-white"
                                                    :disabled="loading"
                                                    @click="certificado_apresentacao_coautor(user.id, 'sul')"
                                                    >
                                                    Baixar
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 layout-spacing" v-if="user && user.is_coautor_centrooeste_2022">
                                <div class="widget widget-account-invoice-two">
                                    <div class="widget-content">
                                        <div class="account-box">
                                            <div class="info">
                                                <div class="inv-title">
                                                    <h4 class="" style="color:#FFF;">Regional Centro Oeste - Coautor</h4>
                                                </div>
                                                <div class="inv-balance-info">
                                                </div>
                                            </div>
                                            <div class="acc-action">
                                                <button
                                                    v-if="user && user.is_coautor_centrooeste_2022"
                                                    v-tooltip.bottom="{
                                                    content: 'Certificado de Apresentação de trabalho',
                                                    delay: 0,
                                                    class: 'tooltip-custom tooltip-arrow'
                                                    }"
                                                    title="Certificado de Apresentação de trabalho"
                                                    class="btn btn-info btn-sm m-1 text-white"
                                                    :disabled="loading"
                                                    @click="certificado_apresentacao_coautor(user.id, 'centrooeste')"
                                                    >
                                                    Baixar
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <hr>

            <!-- CERTIFICADOS APRESENTAÇÃO EXPOCOM -->
            <div
                v-if="
                    user && user.regional_centrooeste && user.regional_centrooeste.presenca == 1 && user.regional_centrooeste.submissao_expocom && user.regional_centrooeste.submissao_expocom.apresentacao == 1
                ||  user && user.regional_nordeste && user.regional_nordeste.presenca == 1 && user.regional_nordeste.submissao_expocom && user.regional_nordeste.submissao_expocom.apresentacao == 1
                ||  user && user.regional_suldeste && user.regional_suldeste.presenca == 1 && user.regional_suldeste.submissao_expocom && user.regional_suldeste.submissao_expocom.apresentacao == 1
                ||  user && user.regional_norte && user.regional_norte.presenca == 1 && user.regional_norte.submissao_expocom && user.regional_norte.submissao_expocom.apresentacao == 1
                ||  user && user.regional_sul && user.regional_sul.presenca == 1 && user.regional_sul.submissao_expocom && user.regional_sul.submissao_expocom.apresentacao == 1    
                ||  user && user.is_coautor_norte_expo_2022 && user.pago_regional_norte_2022
                ||  user && user.is_coautor_nordeste_expo_2022 && user.pago_regional_nordeste_2022
                ||  user && user.is_coautor_sudeste_expo_2022 && user.pago_regional_suldeste_2022
                ||  user && user.is_coautor_sul_expo_2022 && user.pago_regional_sul_2022
                ||  user && user.is_coautor_centrooeste_expo_2022 && user.pago_regional_centrooeste_2022
  
                "
            >
                <div class="card">
                    <div class="card-header">
                        Certificado de Apresentação de trabalho expocom
                    </div>

                    <div class="card-body pb-2">
                        <!-- EXPOCOM -->
                        <div class="row">
                            <div 
                                class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 layout-spacing"
                                v-if="user && user.regional_nordeste && user.regional_nordeste.presenca == 1
                                && user.regional_nordeste.submissao_expocom && user.regional_nordeste.submissao_expocom.apresentacao == 1"
                            >
                                <div class="widget widget-account-invoice-two">
                                    <div class="widget-content">
                                        <div class="account-box">
                                            <div class="info">
                                                <div class="inv-title">
                                                    <h4 class="" style="color:#FFF;">Regional Nordeste</h4>
                                                </div>
                                                <div class="inv-balance-info">
                                                </div>
                                            </div>
                                            <div class="acc-action">
                                                <button
                                                    v-if="user && user.regional_nordeste && user.regional_nordeste.presenca == 1
                                                    && user.regional_nordeste.submissao_expocom && user.regional_nordeste.submissao_expocom.apresentacao == 1"
                                                    v-tooltip.bottom="{
                                                    content: 'Certificado de Apresentação de trabalho expocom',
                                                    delay: 0,
                                                    class: 'tooltip-custom tooltip-arrow'
                                                    }"
                                                    title="Certificado de Apresentação de trabalho expocom"
                                                    class="btn btn-info btn-sm m-1 text-white"
                                                    :disabled="loading"
                                                    @click="certificado_apresentacao_expocom(user.id, user.regional_nordeste.regiao, user.regional_nordeste.id)"
                                                    >
                                                    Baixar
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div 
                                class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 layout-spacing"
                                v-if="user && user.regional_norte && user.regional_norte.presenca == 1
                                && user.regional_norte.submissao_expocom && user.regional_norte.submissao_expocom.apresentacao == 1"
                            >
                                <div class="widget widget-account-invoice-two">
                                    <div class="widget-content">
                                        <div class="account-box">
                                            <div class="info">
                                                <div class="inv-title">
                                                    <h4 class="" style="color:#FFF;">Regional Norte</h4>
                                                </div>
                                                <div class="inv-balance-info">
                                                </div>
                                            </div>
                                            <div class="acc-action">
                                                <button
                                                    v-if="user && user.regional_norte && user.regional_norte.presenca == 1
                                                    && user.regional_norte.submissao_expocom && user.regional_norte.submissao_expocom.apresentacao == 1"
                                                    v-tooltip.bottom="{
                                                    content: 'Certificado de Apresentação de trabalho expocom',
                                                    delay: 0,
                                                    class: 'tooltip-custom tooltip-arrow'
                                                    }"
                                                    title="Certificado de Apresentação de trabalho expocom"
                                                    class="btn btn-info btn-sm m-1 text-white"
                                                    :disabled="loading"
                                                    @click="certificado_apresentacao_expocom(user.id, user.regional_norte.regiao, user.regional_norte.id)"
                                                    >
                                                    Baixar
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div 
                                class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 layout-spacing"
                                v-if="user && user.regional_suldeste && user.regional_suldeste.presenca == 1
                                && user.regional_suldeste.submissao_expocom && user.regional_suldeste.submissao_expocom.apresentacao == 1"
                            >
                                <div class="widget widget-account-invoice-two">
                                    <div class="widget-content">
                                        <div class="account-box">
                                            <div class="info">
                                                <div class="inv-title">
                                                    <h4 class="" style="color:#FFF;">Regional Sudeste</h4>
                                                </div>
                                                <div class="inv-balance-info">
                                                </div>
                                            </div>
                                            <div class="acc-action">
                                                <button
                                                    v-if="user && user.regional_suldeste && user.regional_suldeste.presenca == 1
                                                    && user.regional_suldeste.submissao_expocom && user.regional_suldeste.submissao_expocom.apresentacao == 1"
                                                    v-tooltip.bottom="{
                                                    content: 'Certificado de Apresentação de trabalho expocom',
                                                    delay: 0,
                                                    class: 'tooltip-custom tooltip-arrow'
                                                    }"
                                                    title="Certificado de Apresentação de trabalho expocom"
                                                    class="btn btn-info btn-sm m-1 text-white"
                                                    :disabled="loading"
                                                    @click="certificado_apresentacao_expocom(user.id, user.regional_suldeste.regiao, user.regional_suldeste.id)"
                                                    >
                                                    Baixar
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div 
                                class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 layout-spacing"
                                v-if="user && user.regional_centrooeste && user.regional_centrooeste.presenca == 1
                                && user.regional_centrooeste.submissao_expocom && user.regional_centrooeste.submissao_expocom.apresentacao == 1"
                            >
                                <div class="widget widget-account-invoice-two">
                                    <div class="widget-content">
                                        <div class="account-box">
                                            <div class="info">
                                                <div class="inv-title">
                                                    <h4 class="" style="color:#FFF;">Regional Centro Oeste</h4>
                                                </div>
                                                <div class="inv-balance-info">
                                                </div>
                                            </div>
                                            <div class="acc-action">
                                                <button
                                                    v-if="user && user.regional_centrooeste && user.regional_centrooeste.presenca == 1
                                                    && user.regional_centrooeste.submissao_expocom && user.regional_centrooeste.submissao_expocom.apresentacao == 1"
                                                    v-tooltip.bottom="{
                                                    content: 'Certificado de Apresentação de trabalho expocom',
                                                    delay: 0,
                                                    class: 'tooltip-custom tooltip-arrow'
                                                    }"
                                                    title="Certificado de Apresentação de trabalho expocom"
                                                    class="btn btn-info btn-sm m-1 text-white"
                                                    :disabled="loading"
                                                    @click="certificado_apresentacao_expocom(user.id, user.regional_centrooeste.regiao, user.regional_centrooeste.id)"
                                                    >
                                                    Baixar
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div 
                                class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 layout-spacing"
                                v-if="user && user.regional_sul && user.regional_sul.presenca == 1
                                && user.regional_sul.submissao_expocom && user.regional_sul.submissao_expocom.apresentacao == 1"
                            >
                                <div class="widget widget-account-invoice-two">
                                    <div class="widget-content">
                                        <div class="account-box">
                                            <div class="info">
                                                <div class="inv-title">
                                                    <h4 class="" style="color:#FFF;">Regional Sul</h4>
                                                </div>
                                                <div class="inv-balance-info">
                                                </div>
                                            </div>
                                            <div class="acc-action">
                                                <button
                                                    v-if="user && user.regional_sul && user.regional_sul.presenca == 1
                                                    && user.regional_sul.submissao_expocom && user.regional_sul.submissao_expocom.apresentacao == 1"
                                                    v-tooltip.bottom="{
                                                    content: 'Certificado de Apresentação de trabalho expocom',
                                                    delay: 0,
                                                    class: 'tooltip-custom tooltip-arrow'
                                                    }"
                                                    title="Certificado de Apresentação de trabalho expocom"
                                                    class="btn btn-info btn-sm m-1 text-white"
                                                    :disabled="loading"
                                                    @click="certificado_apresentacao_expocom(user.id, user.regional_sul.regiao, user.regional_sul.id)"
                                                    >
                                                    Baixar
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- COAUTOR EXPOCOM -->
                        <div class="row">
                            <div 
                                class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 layout-spacing"
                                v-if="user && user.is_coautor_nordeste_expo_2022"
                            >
                                <div class="widget widget-account-invoice-two">
                                    <div class="widget-content">
                                        <div class="account-box">
                                            <div class="info">
                                                <div class="inv-title">
                                                    <h4 class="" style="color:#FFF;">Regional Nordeste - Coautor</h4>
                                                </div>
                                                <div class="inv-balance-info">
                                                </div>
                                            </div>
                                            <div class="acc-action">
                                                <button
                                                    v-if="user && user.is_coautor_nordeste_expo_2022"
                                                    v-tooltip.bottom="{
                                                    content: 'Certificado de Apresentação de trabalho expocom',
                                                    delay: 0,
                                                    class: 'tooltip-custom tooltip-arrow'
                                                    }"
                                                    title="Certificado de Apresentação de trabalho expocom"
                                                    class="btn btn-info btn-sm m-1 text-white"
                                                    :disabled="loading"
                                                    @click="certificado_apresentacao_expocom_coautor(user.id, 'nordeste')"
                                                    >
                                                    Baixar
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div 
                                class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 layout-spacing"
                                v-if="user && user.is_coautor_sudeste_expo_2022"
                            >
                                <div class="widget widget-account-invoice-two">
                                    <div class="widget-content">
                                        <div class="account-box">
                                            <div class="info">
                                                <div class="inv-title">
                                                    <h4 class="" style="color:#FFF;">Regional Sudeste - Coautor</h4>
                                                </div>
                                                <div class="inv-balance-info">
                                                </div>
                                            </div>
                                            <div class="acc-action">
                                                <button
                                                    v-if="user && user.is_coautor_sudeste_expo_2022"
                                                    v-tooltip.bottom="{
                                                    content: 'Certificado de Apresentação de trabalho expocom',
                                                    delay: 0,
                                                    class: 'tooltip-custom tooltip-arrow'
                                                    }"
                                                    title="Certificado de Apresentação de trabalho expocom"
                                                    class="btn btn-info btn-sm m-1 text-white"
                                                    :disabled="loading"
                                                    @click="certificado_apresentacao_expocom_coautor(user.id, 'suldeste')"
                                                    >
                                                    Baixar
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div 
                                class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 layout-spacing"
                                v-if="user && user.is_coautor_norte_expo_2022"
                            >
                                <div class="widget widget-account-invoice-two">
                                    <div class="widget-content">
                                        <div class="account-box">
                                            <div class="info">
                                                <div class="inv-title">
                                                    <h4 class="" style="color:#FFF;">Regional Norte - Coautor</h4>
                                                </div>
                                                <div class="inv-balance-info">
                                                </div>
                                            </div>
                                            <div class="acc-action">
                                                <button
                                                    v-if="user && user.is_coautor_norte_expo_2022"
                                                    v-tooltip.bottom="{
                                                    content: 'Certificado de Apresentação de trabalho expocom',
                                                    delay: 0,
                                                    class: 'tooltip-custom tooltip-arrow'
                                                    }"
                                                    title="Certificado de Apresentação de trabalho expocom"
                                                    class="btn btn-info btn-sm m-1 text-white"
                                                    :disabled="loading"
                                                    @click="certificado_apresentacao_expocom_coautor(user.id, 'norte')"
                                                    >
                                                    Baixar
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div 
                                class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 layout-spacing"
                                v-if="user && user.is_coautor_sul_expo_2022"
                            >
                                <div class="widget widget-account-invoice-two">
                                    <div class="widget-content">
                                        <div class="account-box">
                                            <div class="info">
                                                <div class="inv-title">
                                                    <h4 class="" style="color:#FFF;">Regional Sul - Coautor</h4>
                                                </div>
                                                <div class="inv-balance-info">
                                                </div>
                                            </div>
                                            <div class="acc-action">
                                                <button
                                                    v-if="user && user.is_coautor_sul_expo_2022"
                                                    v-tooltip.bottom="{
                                                    content: 'Certificado de Apresentação de trabalho expocom',
                                                    delay: 0,
                                                    class: 'tooltip-custom tooltip-arrow'
                                                    }"
                                                    title="Certificado de Apresentação de trabalho expocom"
                                                    class="btn btn-info btn-sm m-1 text-white"
                                                    :disabled="loading"
                                                    @click="certificado_apresentacao_expocom_coautor(user.id, 'sul')"
                                                    >
                                                    Baixar
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div 
                                class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 layout-spacing"
                                v-if="user && user.is_coautor_centrooeste_expo_2022"
                            >
                                <div class="widget widget-account-invoice-two">
                                    <div class="widget-content">
                                        <div class="account-box">
                                            <div class="info">
                                                <div class="inv-title">
                                                    <h4 class="" style="color:#FFF;">Regional Centro Oeste - Coautor</h4>
                                                </div>
                                                <div class="inv-balance-info">
                                                </div>
                                            </div>
                                            <div class="acc-action">
                                                <button
                                                    v-if="user && user.is_coautor_centrooeste_expo_2022"
                                                    v-tooltip.bottom="{
                                                    content: 'Certificado de Apresentação de trabalho expocom',
                                                    delay: 0,
                                                    class: 'tooltip-custom tooltip-arrow'
                                                    }"
                                                    title="Certificado de Apresentação de trabalho expocom"
                                                    class="btn btn-info btn-sm m-1 text-white"
                                                    :disabled="loading"
                                                    @click="certificado_apresentacao_expocom_coautor(user.id, 'centrooeste')"
                                                    >
                                                    Baixar
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr>

            <!-- CERTIFICADOS VENCEDOR -->
            <div
                v-if="user && user.regional_norte && user.regional_norte.presenca == 1 
                && user.regional_norte.submissao_expocom && user.regional_norte.submissao_expocom.apresentacao == 1 
                && user.regional_norte.submissao_expocom.vencedor == 1

                || user && user.regional_centrooeste && user.regional_centrooeste.presenca == 1
                && user.regional_centrooeste.submissao_expocom && user.regional_centrooeste.submissao_expocom.apresentacao == 1
                && user.regional_centrooeste.submissao_expocom.vencedor == 1
                
                || user && user.regional_nordeste && user.regional_nordeste.presenca == 1
                && user.regional_nordeste.submissao_expocom && user.regional_nordeste.submissao_expocom.apresentacao == 1
                && user.regional_nordeste.submissao_expocom.vencedor == 1

                || user && user.regional_sul && user.regional_sul.presenca == 1
                && user.regional_sul.submissao_expocom && user.regional_sul.submissao_expocom.apresentacao == 1
                && user.regional_sul.submissao_expocom.vencedor == 1

                || user && user.regional_suldeste && user.regional_suldeste.presenca == 1
                && user.regional_suldeste.submissao_expocom && user.regional_suldeste.submissao_expocom.apresentacao == 1
                && user.regional_suldeste.submissao_expocom.vencedor == 1

                || user && user.is_coautor_nordeste_expo_vencedor_2022 && user.pago_regional_nordeste_2022
                || user && user.is_coautor_sudeste_expo_vencedor_2022 && user.pago_regional_suldeste_2022
                || user && user.is_coautor_norte_expo_vencedor_2022 && user.pago_regional_norte_2022
                || user && user.is_coautor_centrooeste_expo_vencedor_2022 && user.pago_regional_centrooeste_2022
                || user && user.is_coautor_sul_expo_vencedor_2022 && user.pago_regional_sul_2022
                "
            >
                <div class="card">
                    <div class="card-header">
                        Certificado vencedor expocom
                    </div>

                    <div class="card-body pb-2">
                        <!-- EXPOCOM -->
                        <div class="row">
                            <div 
                                class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 layout-spacing"
                                v-if="user && user.regional_nordeste && user.regional_nordeste.presenca == 1
                                    && user.regional_nordeste.submissao_expocom && user.regional_nordeste.submissao_expocom.apresentacao == 1
                                    && user.regional_nordeste.submissao_expocom.vencedor == 1"
                            >
                                <div class="widget widget-account-invoice-two">
                                    <div class="widget-content">
                                        <div class="account-box">
                                            <div class="info">
                                                <div class="inv-title">
                                                    <h4 class="" style="color:#FFF;">Regional Nordeste</h4>
                                                </div>
                                                <div class="inv-balance-info">
                                                </div>
                                            </div>
                                            <div class="acc-action">
                                                <button
                                                    v-if="user && user.regional_nordeste && user.regional_nordeste.presenca == 1
                                                        && user.regional_nordeste.submissao_expocom && user.regional_nordeste.submissao_expocom.apresentacao == 1
                                                        && user.regional_nordeste.submissao_expocom.vencedor == 1"

                                                    v-tooltip.bottom="{
                                                    content: 'Certificado vencedor expocom',
                                                    delay: 0,
                                                    class: 'tooltip-custom tooltip-arrow'
                                                    }"
                                                    title="Certificado vencedor expocom"
                                                    class="btn btn-info btn-sm m-1 text-white"
                                                    :disabled="loading"
                                                    @click="certificado_vencedor_expocom(user.id, user.regional_nordeste.regiao, user.regional_nordeste.id)"
                                                    >
                                                    Baixar
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div 
                                class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 layout-spacing"
                                v-if="user && user.regional_norte && user.regional_norte.presenca == 1
                                    && user.regional_norte.submissao_expocom && user.regional_norte.submissao_expocom.apresentacao == 1
                                    && user.regional_norte.submissao_expocom.vencedor == 1"
                            >
                                <div class="widget widget-account-invoice-two">
                                    <div class="widget-content">
                                        <div class="account-box">
                                            <div class="info">
                                                <div class="inv-title">
                                                    <h4 class="" style="color:#FFF;">Regional Norte</h4>
                                                </div>
                                                <div class="inv-balance-info">
                                                </div>
                                            </div>
                                            <div class="acc-action">
                                                <button
                                                    v-if="user && user.regional_norte && user.regional_norte.presenca == 1
                                                        && user.regional_norte.submissao_expocom && user.regional_norte.submissao_expocom.apresentacao == 1
                                                        && user.regional_norte.submissao_expocom.vencedor == 1"

                                                    v-tooltip.bottom="{
                                                    content: 'Certificado vencedor expocom',
                                                    delay: 0,
                                                    class: 'tooltip-custom tooltip-arrow'
                                                    }"
                                                    title="Certificado vencedor expocom"
                                                    class="btn btn-info btn-sm m-1 text-white"
                                                    :disabled="loading"
                                                    @click="certificado_vencedor_expocom(user.id, user.regional_norte.regiao, user.regional_norte.id)"
                                                    >
                                                    Baixar
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div 
                                class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 layout-spacing"
                                v-if="user && user.regional_suldeste && user.regional_suldeste.presenca == 1
                                    && user.regional_suldeste.submissao_expocom && user.regional_suldeste.submissao_expocom.apresentacao == 1
                                    && user.regional_suldeste.submissao_expocom.vencedor == 1"
                            >
                                <div class="widget widget-account-invoice-two">
                                    <div class="widget-content">
                                        <div class="account-box">
                                            <div class="info">
                                                <div class="inv-title">
                                                    <h4 class="" style="color:#FFF;">Regional Sudeste</h4>
                                                </div>
                                                <div class="inv-balance-info">
                                                </div>
                                            </div>
                                            <div class="acc-action">
                                                <button
                                                    v-if="user && user.regional_suldeste && user.regional_suldeste.presenca == 1
                                                        && user.regional_suldeste.submissao_expocom && user.regional_suldeste.submissao_expocom.apresentacao == 1
                                                        && user.regional_suldeste.submissao_expocom.vencedor == 1"

                                                    v-tooltip.bottom="{
                                                    content: 'Certificado vencedor expocom',
                                                    delay: 0,
                                                    class: 'tooltip-custom tooltip-arrow'
                                                    }"
                                                    title="Certificado vencedor expocom"
                                                    class="btn btn-info btn-sm m-1 text-white"
                                                    :disabled="loading"
                                                    @click="certificado_vencedor_expocom(user.id, user.regional_suldeste.regiao, user.regional_suldeste.id)"
                                                    >
                                                    Baixar
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div 
                                class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 layout-spacing"
                                v-if="user && user.regional_centrooeste && user.regional_centrooeste.presenca == 1
                                    && user.regional_centrooeste.submissao_expocom && user.regional_centrooeste.submissao_expocom.apresentacao == 1
                                    && user.regional_centrooeste.submissao_expocom.vencedor == 1"
                            >
                                <div class="widget widget-account-invoice-two">
                                    <div class="widget-content">
                                        <div class="account-box">
                                            <div class="info">
                                                <div class="inv-title">
                                                    <h4 class="" style="color:#FFF;">Regional Centro Oeste</h4>
                                                </div>
                                                <div class="inv-balance-info">
                                                </div>
                                            </div>
                                            <div class="acc-action">
                                                <button
                                                    v-if="user && user.regional_centrooeste && user.regional_centrooeste.presenca == 1
                                                        && user.regional_centrooeste.submissao_expocom && user.regional_centrooeste.submissao_expocom.apresentacao == 1
                                                        && user.regional_centrooeste.submissao_expocom.vencedor == 1"

                                                    v-tooltip.bottom="{
                                                    content: 'Certificado vencedor expocom',
                                                    delay: 0,
                                                    class: 'tooltip-custom tooltip-arrow'
                                                    }"
                                                    title="Certificado vencedor expocom"
                                                    class="btn btn-info btn-sm m-1 text-white"
                                                    :disabled="loading"
                                                    @click="certificado_vencedor_expocom(user.id, user.regional_centrooeste.regiao, user.regional_centrooeste.id)"
                                                    >
                                                    Baixar
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div 
                                class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 layout-spacing"
                                v-if="user && user.regional_sul && user.regional_sul.presenca == 1
                                    && user.regional_sul.submissao_expocom && user.regional_sul.submissao_expocom.apresentacao == 1
                                    && user.regional_sul.submissao_expocom.vencedor == 1"
                            >
                                <div class="widget widget-account-invoice-two">
                                    <div class="widget-content">
                                        <div class="account-box">
                                            <div class="info">
                                                <div class="inv-title">
                                                    <h4 class="" style="color:#FFF;">Regional Sul</h4>
                                                </div>
                                                <div class="inv-balance-info">
                                                </div>
                                            </div>
                                            <div class="acc-action">
                                                <button
                                                    v-if="user && user.regional_sul && user.regional_sul.presenca == 1
                                                        && user.regional_sul.submissao_expocom && user.regional_sul.submissao_expocom.apresentacao == 1
                                                        && user.regional_sul.submissao_expocom.vencedor == 1"

                                                    v-tooltip.bottom="{
                                                    content: 'Certificado vencedor expocom',
                                                    delay: 0,
                                                    class: 'tooltip-custom tooltip-arrow'
                                                    }"
                                                    title="Certificado vencedor expocom"
                                                    class="btn btn-info btn-sm m-1 text-white"
                                                    :disabled="loading"
                                                    @click="certificado_vencedor_expocom(user.id, user.regional_sul.regiao, user.regional_sul.id)"
                                                    >
                                                    Baixar
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- COAUTOR -->
                        <div class="row">
                            <div 
                                class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 layout-spacing"
                                v-if="user && user.is_coautor_nordeste_expo_vencedor_2022"
                            >
                                <div class="widget widget-account-invoice-two">
                                    <div class="widget-content">
                                        <div class="account-box">
                                            <div class="info">
                                                <div class="inv-title">
                                                    <h4 class="" style="color:#FFF;">Regional Nordeste - Coautor</h4>
                                                </div>
                                                <div class="inv-balance-info">
                                                </div>
                                            </div>
                                            <div class="acc-action">
                                                <button
                                                    v-if="user && user.is_coautor_nordeste_expo_vencedor_2022"
                                                    v-tooltip.bottom="{
                                                    content: 'Certificado vencedor expocom',
                                                    delay: 0,
                                                    class: 'tooltip-custom tooltip-arrow'
                                                    }"
                                                    title="Certificado vencedor expocom"
                                                    class="btn btn-info btn-sm m-1 text-white"
                                                    :disabled="loading"
                                                    @click="certificado_vencedor_expocom_coautor(user.id, 'nordeste')"
                                                    >
                                                    Baixar
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div 
                                class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 layout-spacing"
                                v-if="user && user.is_coautor_sudeste_expo_vencedor_2022"
                            >
                                <div class="widget widget-account-invoice-two">
                                    <div class="widget-content">
                                        <div class="account-box">
                                            <div class="info">
                                                <div class="inv-title">
                                                    <h4 class="" style="color:#FFF;">Regional Sudeste - Coautor</h4>
                                                </div>
                                                <div class="inv-balance-info">
                                                </div>
                                            </div>
                                            <div class="acc-action">
                                                <button
                                                    v-if="user && user.is_coautor_sudeste_expo_vencedor_2022"
                                                    v-tooltip.bottom="{
                                                    content: 'Certificado vencedor expocom',
                                                    delay: 0,
                                                    class: 'tooltip-custom tooltip-arrow'
                                                    }"
                                                    title="Certificado vencedor expocom"
                                                    class="btn btn-info btn-sm m-1 text-white"
                                                    :disabled="loading"
                                                    @click="certificado_vencedor_expocom_coautor(user.id, 'suldeste')"
                                                    >
                                                    Baixar
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div 
                                class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 layout-spacing"
                                v-if="user && user.is_coautor_norte_expo_vencedor_2022"
                            >
                                <div class="widget widget-account-invoice-two">
                                    <div class="widget-content">
                                        <div class="account-box">
                                            <div class="info">
                                                <div class="inv-title">
                                                    <h4 class="" style="color:#FFF;">Regional Norte - Coautor</h4>
                                                </div>
                                                <div class="inv-balance-info">
                                                </div>
                                            </div>
                                            <div class="acc-action">
                                                <button
                                                    v-if="user && user.is_coautor_norte_expo_vencedor_2022"
                                                    v-tooltip.bottom="{
                                                    content: 'Certificado vencedor expocom',
                                                    delay: 0,
                                                    class: 'tooltip-custom tooltip-arrow'
                                                    }"
                                                    title="Certificado vencedor expocom"
                                                    class="btn btn-info btn-sm m-1 text-white"
                                                    :disabled="loading"
                                                    @click="certificado_vencedor_expocom_coautor(user.id, 'norte')"
                                                    >
                                                    Baixar
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div 
                                class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 layout-spacing"
                                v-if="user && user.is_coautor_centrooeste_expo_vencedor_2022"
                            >
                                <div class="widget widget-account-invoice-two">
                                    <div class="widget-content">
                                        <div class="account-box">
                                            <div class="info">
                                                <div class="inv-title">
                                                    <h4 class="" style="color:#FFF;">Regional Centro Oeste - Coautor</h4>
                                                </div>
                                                <div class="inv-balance-info">
                                                </div>
                                            </div>
                                            <div class="acc-action">
                                                <button
                                                    v-if="user && user.is_coautor_centrooeste_expo_vencedor_2022"
                                                    v-tooltip.bottom="{
                                                    content: 'Certificado vencedor expocom',
                                                    delay: 0,
                                                    class: 'tooltip-custom tooltip-arrow'
                                                    }"
                                                    title="Certificado vencedor expocom"
                                                    class="btn btn-info btn-sm m-1 text-white"
                                                    :disabled="loading"
                                                    @click="certificado_vencedor_expocom_coautor(user.id, 'centrooeste')"
                                                    >
                                                    Baixar
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div 
                                class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 layout-spacing"
                                v-if="user && user.is_coautor_sul_expo_vencedor_2022"
                            >
                                <div class="widget widget-account-invoice-two">
                                    <div class="widget-content">
                                        <div class="account-box">
                                            <div class="info">
                                                <div class="inv-title">
                                                    <h4 class="" style="color:#FFF;">Regional Sul - Coautor</h4>
                                                </div>
                                                <div class="inv-balance-info">
                                                </div>
                                            </div>
                                            <div class="acc-action">
                                                <button
                                                    v-if="user && user.is_coautor_sul_expo_vencedor_2022"
                                                    v-tooltip.bottom="{
                                                    content: 'Certificado vencedor expocom',
                                                    delay: 0,
                                                    class: 'tooltip-custom tooltip-arrow'
                                                    }"
                                                    title="Certificado vencedor expocom"
                                                    class="btn btn-info btn-sm m-1 text-white"
                                                    :disabled="loading"
                                                    @click="certificado_vencedor_expocom_coautor(user.id, 'sul')"
                                                    >
                                                    Baixar
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <hr>

        <!-- CERTIFICADOS PARECERISTA DT -->
            <div v-if="user && user.avaliou_trabalho_expo_2022 || user && user.avaliou_trabalho_dt_2022">
                <div class="card">
                    <div class="card-header">Certificado de parecerista</div>
                    <div class="card-body pb-2">
                        <!-- DT -->
                        <div class="row">
                            <div 
                                class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 layout-spacing"
                                v-if="user && user.avaliou_trabalho_expo_2022"
                            >
                                <div class="widget widget-account-invoice-two">
                                    <div class="widget-content">
                                        <div class="account-box">
                                            <div class="info">
                                                <div class="inv-title">
                                                    <h4 class="" style="color:#FFF;">PARECERISTA EXPOCOM</h4>
                                                </div>
                                                <div class="inv-balance-info">
                                                </div>
                                            </div>
                                            <div class="acc-action">
                                                <button
                                                    v-if="user && user.avaliou_trabalho_expo_2022"
                                                    v-tooltip.bottom="{
                                                    content: 'Certificado de parecerista expocom',
                                                    delay: 0,
                                                    class: 'tooltip-custom tooltip-arrow'
                                                    }"
                                                    title="Certificado de parecerista expocom"
                                                    class="btn btn-info btn-sm m-1 text-white"
                                                    :disabled="loading"
                                                    @click="certificado_parecerista_expocom(user.id)"
                                                    >
                                                    Baixar
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div 
                                class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 layout-spacing"
                                v-if="user && user.avaliou_trabalho_dt_2022"
                            >
                                <div class="widget widget-account-invoice-two">
                                    <div class="widget-content">
                                        <div class="account-box">
                                            <div class="info">
                                                <div class="inv-title">
                                                    <h4 class="" style="color:#FFF;">PARECERISTA</h4>
                                                </div>
                                                <div class="inv-balance-info">
                                                </div>
                                            </div>
                                            <div class="acc-action">
                                                <button
                                                    v-if="user && user.avaliou_trabalho_dt_2022"
                                                    v-tooltip.bottom="{
                                                    content: 'Certificado de parecerista',
                                                    delay: 0,
                                                    class: 'tooltip-custom tooltip-arrow'
                                                    }"
                                                    title="Certificado de parecerista"
                                                    class="btn btn-info btn-sm m-1 text-white"
                                                    :disabled="loading"
                                                    @click="certificado_parecerista(user.id)"
                                                    >
                                                    Baixar
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <notifications group="submit" position="center bottom" />
    </div>
</template>

<script>
    import debounce from 'debounce'
    import GridMixin from '../mixins/grid-noauth-mixin'

    export default {
        props: ['user'],
        mixins: [GridMixin],
        components: {
        },
        data() {
            return {
                baseUrl: process.env.MIX_BASE_URL,
                loading: false,
                selected: null,
                toDelete: null
            }
        },
        methods: {
            certificado_presenca(user_id, regiao, regional_id){
                this.loading = true
                axios.get(`${process.env.MIX_BASE_URL}/certificados/certificado_presenca/pdf/${user_id}/${regiao}/${regional_id}`, {responseType: 'blob'}).then(res => {
                    if(res.data){
                        var newBlob = new Blob([res.data], {type: "application/pdf"})
                        const data = window.URL.createObjectURL(newBlob);
                        var link = document.createElement('a');
                        link.href = data;
                        link.download="certificado_presenca.pdf";
                        link.click();
                        setTimeout(function(){
                            window.URL.revokeObjectURL(data);
                        }, 100);
                        this.loading = false
                    }
                })
            },
            certificado_apresentacao(user_id, regiao, regional_id){
                this.loading = true
                axios.get(`${process.env.MIX_BASE_URL}/certificados/certificado_apresentacao/pdf/${user_id}/${regiao}/${regional_id}`, {responseType: 'blob'}).then(res => {
                    if(res.data){
                        var newBlob = new Blob([res.data], {type: "application/pdf"})
                        const data = window.URL.createObjectURL(newBlob);
                        var link = document.createElement('a');
                        link.href = data;
                        link.download="certificado_apresentacao.pdf";
                        link.click();
                        setTimeout(function(){
                            window.URL.revokeObjectURL(data);
                        }, 100);
                        this.loading = false
                    }
                })
            },
            certificado_apresentacao_coautor(user_id, regiao){
                this.loading = true
                axios.get(`${process.env.MIX_BASE_URL}/certificados/certificado_apresentacao_coautor/pdf/${user_id}/${regiao}`, {responseType: 'blob'}).then(res => {
                    if(res.data){
                        var newBlob = new Blob([res.data], {type: "application/pdf"})
                        const data = window.URL.createObjectURL(newBlob);
                        var link = document.createElement('a');
                        link.href = data;
                        link.download="certificado_apresentacao_coautor.pdf";
                        link.click();
                        setTimeout(function(){
                            window.URL.revokeObjectURL(data);
                        }, 100);
                        this.loading = false
                    }
                })
            },

            certificado_apresentacao_expocom(user_id, regiao, regional_id){
                this.loading = true
                axios.get(`${process.env.MIX_BASE_URL}/certificados/certificado_apresentacao_expocom/pdf/${user_id}/${regiao}/${regional_id}`, {responseType: 'blob'}).then(res => {
                    if(res.data){
                        var newBlob = new Blob([res.data], {type: "application/pdf"})
                        const data = window.URL.createObjectURL(newBlob);
                        var link = document.createElement('a');
                        link.href = data;
                        link.download="certificado_apresentacao_expocom.pdf";
                        link.click();
                        setTimeout(function(){
                            window.URL.revokeObjectURL(data);
                        }, 100);
                        this.loading = false
                    }
                })
            },
            certificado_apresentacao_expocom_coautor(user_id, regiao){
                this.loading = true
                axios.get(`${process.env.MIX_BASE_URL}/certificados/certificado_apresentacao_expocom_coautor/pdf/${user_id}/${regiao}`, {responseType: 'blob'}).then(res => {
                    if(res.data){
                        var newBlob = new Blob([res.data], {type: "application/pdf"})
                        const data = window.URL.createObjectURL(newBlob);
                        var link = document.createElement('a');
                        link.href = data;
                        link.download="certificado_apresentacao_expocom_coautor.pdf";
                        link.click();
                        setTimeout(function(){
                            window.URL.revokeObjectURL(data);
                        }, 100);
                        this.loading = false
                    }
                })
            },
            certificado_vencedor_expocom(user_id, regiao, regional_id){
                this.loading = true
                axios.get(`${process.env.MIX_BASE_URL}/certificados/certificado_vencedor_expocom/pdf/${user_id}/${regiao}/${regional_id}`, {responseType: 'blob'}).then(res => {
                    if(res.data){
                        var newBlob = new Blob([res.data], {type: "application/pdf"})
                        const data = window.URL.createObjectURL(newBlob);
                        var link = document.createElement('a');
                        link.href = data;
                        link.download="certificado_vencedor_expocom.pdf";
                        link.click();
                        setTimeout(function(){
                            window.URL.revokeObjectURL(data);
                        }, 100);
                        this.loading = false
                    }
                })
            },

            certificado_vencedor_expocom_coautor(user_id, regiao){
                this.loading = true
                axios.get(`${process.env.MIX_BASE_URL}/certificados/certificado_vencedor_expocom_coautor/pdf/${user_id}/${regiao}`, {responseType: 'blob'}).then(res => {
                    if(res.data){
                        var newBlob = new Blob([res.data], {type: "application/pdf"})
                        const data = window.URL.createObjectURL(newBlob);
                        var link = document.createElement('a');
                        link.href = data;
                        link.download="certificado_vencedor_expocom_coautor.pdf";
                        link.click();
                        setTimeout(function(){
                            window.URL.revokeObjectURL(data);
                        }, 100);
                        this.loading = false
                    }
                })
            },
            certificado_parecerista_expocom(user_id){
                this.loading = true
                axios.get(`${process.env.MIX_BASE_URL}/certificados/certificado_parecerista_expocom/pdf/${user_id}`, {responseType: 'blob'}).then(res => {
                    if(res.data){
                        var newBlob = new Blob([res.data], {type: "application/pdf"})
                        const data = window.URL.createObjectURL(newBlob);
                        var link = document.createElement('a');
                        link.href = data;
                        link.download="certificado_parecerista_expocom.pdf";
                        link.click();
                        setTimeout(function(){
                            window.URL.revokeObjectURL(data);
                        }, 100);
                        this.loading = false
                    }
                })
            },
            certificado_parecerista(user_id){
                this.loading = true
                axios.get(`${process.env.MIX_BASE_URL}/certificados/certificado_parecerista/pdf/${user_id}`, {responseType: 'blob'}).then(res => {
                    if(res.data){
                        var newBlob = new Blob([res.data], {type: "application/pdf"})
                        const data = window.URL.createObjectURL(newBlob);
                        var link = document.createElement('a');
                        link.href = data;
                        link.download="certificado_apresentacao.pdf";
                        link.click();
                        setTimeout(function(){
                            window.URL.revokeObjectURL(data);
                        }, 100);
                        this.loading = false
                    }
                })
            },
        },
        async created() {
        },
        mounted() {
            if(this.user){
                if(this.user && this.user.regional_nordeste && this.user.regional_nordeste.submissao_dt){
                    this.user.regional_nordeste.submissao = this.user.regional_nordeste.submissao_dt
                }

                if(this.user && this.user.regional_nordeste && this.user.regional_nordeste.submissao_mesa){
                    this.user.regional_nordeste.submissao = this.user.regional_nordeste.submissao_mesa
                }

                if(this.user && this.user.regional_nordeste && this.user.regional_nordeste.submissao_junior){
                    this.user.regional_nordeste.submissao = this.user.regional_nordeste.submissao_junior
                }
            }
        },
        destroyed () {
        },
    }
</script>
