<?php
template('header', array(
  'title' => 'Boite à outils • Convertisseur',
));
?>

<!-- ======= About Section ======= -->
<section id="homepage" class="homepage">
  <div class="container">
    <div class="section-title">
      <h2>Convertisseur</h2>
    </div>

    <div class="row">

      <fieldset class="col-12 mt-4">
        <legend>Convertisseur de devises</legend>
        <label for="clear">Montant à convertir</label>
        <form action="" method="post" name="devises">
          <div class="form-group row mb-3">
            <div class="col-md-4">
              <label for="amount" aria-hidden="true" hidden>Montant</label>
              <div class="input-group">
                <input id="amount" name="amount" type="number" class="form-control" required>
                <div class="input-group-append">
                  <select id="from" name="from" class="form-select" aria-label="From" required>
                    <option value="" disabled selected>De</option>
                    <option value="EUR" selected>EUR</option>
                    <option value="USD">USD</option>
                    <option value="GBP">GBP</option>
                    <option value="JPY">JPY</option>
                    <option value="CHF">CHF</option>
                    <option value="CAD">CAD</option>
                    <option value="AED">AED</option>
                  </select>
                </div>
              </div>
            </div>

            <div class="text-center col-md-2 mb-1 mt-1">
              <span class="ver">vaut actuellement</span>
            </div>

            <div class="col-md-4">
              <label for="result" aria-hidden="true" hidden>Montant converti</label>
              <div class="input-group">
                <input id="result" name="result" type="number" class="form-control" disabled>
                <div class="input-group-append">
                  <div class="input-group-text">
                    <select id="to" name="to" class="form-select" aria-label="To" required>
                      <option value="" disabled selected>À</option>
                      <option value="EUR">EUR</option>
                      <option value="USD" selected>USD</option>
                      <option value="GBP">GBP</option>
                      <option value="JPY">JPY</option>
                      <option value="CHF">CHF</option>
                      <option value="CAD">CAD</option>
                      <option value="AED">AED</option>
                    </select>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-2 mt-2 mt-md-0 m-auto col-4">
              <button name="submit" type="submit" class="btn btn-primary btn-block">Convertir</button>
            </div>
          </div>
        </form>
      </fieldset>

      <fieldset class="col-12 mt-4">
        <legend>Volume à convertir</legend>
        <form action="" method="post" name="volume">
          <div class="form-group row mb-3">
            <div class="col-md-4">
              <label for="volume" aria-hidden="true" hidden>Volume</label>
              <div class="input-group">
                <input id="volume" name="volume" type="number" class="form-control" required>
                <div class="input-group-append">
                  <select id="from" name="from" class="form-select" aria-label="From" required>
                    <option value="" disabled selected>De</option>
                    <option value="0.001">Millilitre</option>
                    <option value="0.01">Centilitre</option>
                    <option value="0.1">Décilitre</option>
                    <option value="1"selected>Litre</option>
                    <option value="10">Décalitre</option>
                    <option value="100">Hectolitre</option>
                    <option value="1000">Kilolitre</option>
                  </select>
                </div>
              </div>
            </div>

            <div class="text-center col-md-2 mb-1 mt-1">
              <span class="ver">vaut actuellement</span>
            </div>

            <div class="col-md-4">
              <label for="result" aria-hidden="true" hidden>Volume converti</label>
              <div class="input-group">
                <input id="result" name="result" type="number" class="form-control" disabled>
                <div class="input-group-append">
                  <div class="input-group-text">
                    <select id="to" name="to" class="form-select" aria-label="To" required>
                      <option value="" disabled selected>À</option>
                      <option value="0.001"selected>Millilitre</option>
                      <option value="0.01">Centilitre</option>
                      <option value="0.1">Décilitre</option>
                      <option value="1">Litre</option>
                      <option value="10">Décalitre</option>
                      <option value="100">Hectolitre</option>
                      <option value="1000">Kilolitre</option>
                    </select>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-2 mt-2 mt-md-0 m-auto col-4">
              <button name="submit" type="submit" class="btn btn-primary btn-block">Convertir</button>
            </div>
          </div>
        </form>
      </fieldset>
    </div>
  </div>
</section><!-- End Home Section -->


<script type="text/javascript">
  window.addEventListener('load', () => {
    let forms = document.forms;

    for (form of forms) {
      form.addEventListener('submit', async (event) => {
        event.preventDefault();

        const formData = new FormData(event.target).entries()

        const response = await fetch('/api/post', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify(
            Object.assign(Object.fromEntries(formData), {
              form: event.target.name
            })
          )
        });

        const result = await response.json();

        let inputName = Object.keys(result.data)[0];

        event.target.querySelector(`input[name="${inputName}"]`).value = result.data[inputName];
      })
    }
  });
</script>

<?php template('footer');
