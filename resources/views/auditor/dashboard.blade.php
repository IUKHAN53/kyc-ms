<x-app-layout>
    <div class="row">
        <div class="col-12">
          <div class="ds-title">
            <p class="date">5 de Maio de 2024</p>
            <h2>Bom dia, Rafael Medeiros</h2>
          </div>
        </div>
      </div>
      <div class="row gx-3">
        <div class="col-12 col-md-12 col-lg-4 col-xl-4">
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
        <div class="col-12 col-md-12 col-lg-8 col-xl-8">
          <div class="ds-grap">
            <h2>Minhas auditorias</h2>
            <p class="month">Visualização: <span>últimos 12 meses</span></p>

            <div style="height: 200px;">
              <canvas id="myChart"></canvas>
            </div>
          </div>
        </div>
      </div>
</x-app-layout>
