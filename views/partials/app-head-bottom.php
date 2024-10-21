
</head>
  <body>
    <div class="wrapper">
      <sidebar>
        <h1>ADAM'S<br>ICE CREAM</h1>
        <div class="line"></div>
        <div class="nav-container">

          <a href="/dashboard" class="nav-btn" style="<?= currentUrl('/dashboard') ? 'background-color: #F3F3F8; color: #334259; font-weight: 600' : "" ?>">
            <div class="icon-container">
            <svg style="<?= currentUrl('/dashboard') ? "fill: purple;" : "fill: white;" ?>" xmlns="http://www.w3.org/2000/svg" id="Layer_1" data-name="Layer 1" viewBox="0 0 24 24">
              <path d="M19,3H5C2.239,3,0,5.239,0,8v8c0,2.761,2.239,5,5,5h14c2.761,0,5-2.239,5-5V8c0-2.761-2.239-5-5-5ZM6.802,17.359c-1.909-.449-3.404-2.058-3.729-3.992-.469-2.791,1.377-5.249,3.927-5.767v4.485c0,.53,.211,1.039,.586,1.414l3.169,3.169c-1.093,.724-2.482,1.036-3.952,.691Zm5.366-2.105l-2.876-2.876c-.188-.188-.293-.442-.293-.707V7.601c2.282,.463,4,2.48,4,4.899,0,1.019-.308,1.964-.832,2.754Zm7.832,1.746h-3c-.552,0-1-.448-1-1h0c0-.552,.448-1,1-1h3c.552,0,1,.448,1,1h0c0,.552-.448,1-1,1Zm0-4h-3c-.552,0-1-.448-1-1h0c0-.552,.448-1,1-1h3c.552,0,1,.448,1,1h0c0,.552-.448,1-1,1Zm0-4h-3c-.552,0-1-.448-1-1h0c0-.552,.448-1,1-1h3c.552,0,1,.448,1,1h0c0,.552-.448,1-1,1Z"/>
            </svg>
            </div>
            <p>
              Dashboard
            </p>
          </a>

          <a href="/inventory" class="nav-btn" style="<?= currentUrl('/inventory') ? 'background-color: #F3F3F8; color: #334259; font-weight: 600' : "" ?>">
            <div class="icon-container">
              <svg style="<?= currentUrl('/inventory') ? "fill: purple;" : "fill: white;" ?>" xmlns="http://www.w3.org/2000/svg" id="Layer_1" data-name="Layer 1" viewBox="0 0 24 24"><path d="M11,9.401l-2.175,3.624c-.482,.804-1.458,1.165-2.347,.868l-5.081-1.694c-1.23-.41-1.764-1.854-1.097-2.965l1.7-2.834,9,3Zm2,0l2.175,3.624c.482,.804,1.458,1.165,2.347,.868l5.118-1.706c1.211-.404,1.737-1.825,1.08-2.92l-1.72-2.866-9,3Zm-2.46,4.654c-.742,1.236-2.044,1.945-3.415,1.945-.425,0-.856-.067-1.28-.209l-3.845-1.281v6.491l9,3V13.288l-.46,.766Zm7.615,1.736c-.424,.142-.855,.209-1.28,.209-1.371,0-2.673-.708-3.415-1.945l-.46-.766v10.712l9-3v-6.491l-3.845,1.282ZM12,7.627l6.386-2.129-3.912-3.912-5.15,5.149,2.676,.892Zm-4.798-1.599L11.86,1.371,10.525,.036,5.2,5.36l2.002,.667Z"/></svg>
            </div>
            <p>
              Inventory
            </p>
          </a>

          <a href="/orders" class="nav-btn" style="<?= currentUrl('/orders') ? 'background-color: #F3F3F8; color: #334259; font-weight: 600' : "" ?>">
            <div class="icon-container">
            <svg style="<?= currentUrl('/orders') ? "fill: purple;" : "fill: white;" ?>"  xmlns="http://www.w3.org/2000/svg" id="Layer_1" data-name="Layer 1" viewBox="0 0 24 24">
              <path d="M19,0c-2.761,0-5,2.239-5,5s2.239,5,5,5,5-2.239,5-5S21.761,0,19,0Zm1.293,7.707l-2.293-2.293V2h2v2.586l1.707,1.707-1.414,1.414Zm-11.293,14.293c0,1.105-.895,2-2,2s-2-.895-2-2,.895-2,2-2,2,.895,2,2Zm12.835-7H5.654l.131,1.116c.059,.504,.486,.884,.993,.884h13.222v2H6.778c-1.521,0-2.802-1.139-2.979-2.649L2.215,2.884c-.059-.504-.486-.884-.993-.884H0V0H1.222c1.521,0,2.802,1.139,2.979,2.649l.041,.351H12.294c-.189,.634-.294,1.305-.294,2,0,3.866,3.134,7,7,7,1.273,0,2.462-.345,3.49-.938l-.655,3.938Zm-2.835,7c0,1.105-.895,2-2,2s-2-.895-2-2,.895-2,2-2,2,.895,2,2Z"/>
            </svg>
            </div>
            <p>
              Orders
            </p>
          </a>

          <form action="/logout" method="POST" id="logout-form">
          </form>
          
          <button class="nav-btn logout" onclick="document.getElementById('logout-form').submit();">
            Log Out
          </button>

        </div>
      </sidebar>
      <section>
        <h1><?= $heading ?></h1>