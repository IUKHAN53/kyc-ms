<x-app-layout>
    <div class="row">
        <div class="col-12 col-lg-12 col-xl-4">
            <div class="ds-title">
                <h2 class="mb-1">Bom dia, Rafael Medeiros</h2>
                <p class="date">Resumo da Equipe Alfa</p>
            </div>
        </div>
        <div class="col-12 col-lg-12 col-xl-8">
            <ul class="ds-sort text-xl-end">
                <li>Filtrar por:
                    <button><i class="bi bi-people"></i> Consultor</button>
                </li>
            </ul>
        </div>
    </div>
    <div class="row gx-3">
        <div class="col-12 col-md-12 col-lg-12 col-xl-8">
            <div class="row gx-3">
                <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                    <div class="ds-grap">
                        <h2>Conversões do dia</h2>

                        <div class="ds-grap1">
                            <canvas id="conversoesChart" width="200" height="100"></canvas>
                            <h2 class="count" id="conversionValue">0</h2>
                            <p>Conversões</p>
                            <div style="display: flex; justify-content: center; gap: 40px;">
                                <div style="color: green;">
                                    &#8593; <span id="weeklyIncrease">+0,00%</span>
                                    <span>essa semana</span>
                                </div>
                                <div style="color: gray;">
                                    &#8595; <span id="weeklyDecrease">-0,00%</span>
                                    <span>última semana</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                    <div class="ds-grap">
                        <h2>Meta do dia</h2>

                        <div class="row ds-grap2 gx-1">
                            <div class="col">
                                <canvas id="contatosChart"></canvas>
                                <p>Contatos</p>
                            </div>
                            <div class="col">
                                <canvas id="vendasChart"></canvas>
                                <p>Vendas</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row gx-3">
                <div class="col-12">
                    <div class="ds-grap">
                        <h2>Jornada da equipes</h2>
                        <p class="month">Visualização: <span>últimos 12 meses</span></p>

                        <div style="height: 200px;">
                            <canvas id="myChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-12 col-lg-12 col-xl-4">
            <div class="row gx-3">
                <div class="col-12 col-md-6 col-lg-6 col-xl-12">
                    <div class="ds-grap">
                        <h2>Meta do Mês</h2>

                        <div class="ds-progress">
                            <h3><span class="color"></span>Contatos <span class="num">- 32 de 96</span> <span
                                    class="per">69%</span>
                            </h3>
                            <div class="progress" role="progressbar" aria-valuenow="69" aria-valuemin="0"
                                 aria-valuemax="100">
                                <div class="progress-bar" style="width: 69%"></div>
                            </div>
                        </div>
                        <div class="ds-progress mb-0">
                            <h3><span class="color"></span>Vendas <span class="num">- 32 de 96</span> <span class="per">69%</span>
                            </h3>
                            <div class="progress" role="progressbar" aria-valuenow="33" aria-valuemin="0"
                                 aria-valuemax="100">
                                <div class="progress-bar" style="width: 33%"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-6 col-xl-12">
                    <div class="ds-grap">
                        <h2>Valor convertido</h2>
                        <div class="row">
                            <div class="col">
                                <h3 class="price"><span>R$</span> 42.000,32</h3>
                                <h3 class="value mb-0"><img src="{{asset('assets/img/arrow-top-right.png')}}" alt="">
                                    +3,49%
                                    <br><span>essa
                                        semana</span>
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
