<?php
session_start();
?>
<header>
	<nav class="navbar navbar-dark bg-dark navbar-expand-lg">

		<a id="brand" class="navbar-brand" href="/"><img src="img/meettylogo.png" alt="logo" width="32" height="32"
				class="d-inline-block mr-2 align-bottom" alt="">Meetty</a>

		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mainmenu">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="mainmenu">

			<ul class="navbar-nav mr-auto text-center">

				<li class="nav-item">
					<a class="nav-link" href="/"><i class="demo-icon icon-home-outline"></i> Strona Główna </a>
				</li>

				<li class="nav-item">
					<a class="nav-link" href="imprezy.php"><i class="demo-icon icon-megaphone"></i> Imprezy </a>

				</li>

				<li class="nav-item">
					<div class="nav-link disabled"><i class="demo-icon icon-building"></i><del> Lokale </del></div>
				</li>

				<li class="nav-item">
					<div class="nav-link disabled"><i class="demo-icon icon-lifebuoy"></i><del> Pomoc </del></div>
				</li>
			</ul>
			<ul class="navbar-nav text-center">
				<li class="nav-item">
					<a class="btn my-2 btn-light kartabtn" href="dodaj-impreze" role="button">Dodaj własną impreze</a>
				</li>
				<li class="nav-item dropdown">
					<a class="nav-link" data-toggle="dropdown" role="button"> <i class="demo-icon icon-user"
							style="font-size: 30px;"></i> </a>

					<div class="dropdown-menu dropdown-menu-right  ">
						<?php	
          if(!isset($_SESSION['zalogowany']))
          {
					echo '<div class="dropdown-item disabled"><i class="demo-icon icon-user"></i> Profil </div>';
          }
          else
          {
            echo '<a class="dropdown-item" href="profil/'.$_SESSION['id'].'"><i class="demo-icon icon-user"></i> Profil </a>';
          }
          ?>
						<div class="dropdown-divider"></div>
						<?php
					if(isset($_SESSION['zalogowany']))
					{
						echo '<a class="dropdown-item" href="wyloguj"><i class="demo-icon icon-logout"></i> Wyloguj</a>';
					}
					else 
					{
					echo '<a class="dropdown-item" href="logowanie"><i class="demo-icon icon-login"></i> Zaloguj</a>';
					}
					?> </a>
						<a class="dropdown-item" href="rejestracja"><i class="demo-icon icon-clipboard"></i> Rejestracja
						</a>
						<a class="dropdown-item" href="resetowanie-hasla"><i class="demo-icon icon-lock-open-alt"></i>
							Reset hasła </a>
						<?php
							if(isset($_SESSION['zalogowany']))
                        {
						echo  '<a class="dropdown-item" href="ustawienia"><i class="demo-icon icon-cog"></i> Ustawienia konta </a>';
						}
?>
					</div>
				</li>
				<!--<li class="nav-item">
                    <a class="nav-link" role="button" href="apk/Meetty.apk" download="Meetty.apk">
                    <i class="demo-icon icon-android-1" style="font-size: 32px;"></i> </a>
                    </li>!-->
			</ul>
		</div>
		</div>
	</nav>
</header>