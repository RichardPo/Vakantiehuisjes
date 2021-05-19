<html>

    <head>
        <title>Huisjes.nl - Home</title>

        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <script src="https://kit.fontawesome.com/e5272abace.js" crossorigin="anonymous"></script>

        <link href="Resources/CSS/style.css?time=<?= time(); ?>" rel="stylesheet" type="text/css"/>
    </head>

    <body>
        <div class="background">
        	<div class="curve">
                <div style="height: 100%; width: 100% overflow: hidden;" ><svg viewBox="0 0 500 150" preserveAspectRatio="none" style="height: 100%; width: 100%;"><path d="M0.00,49.99 C190.96,118.71 349.20,-49.99 500.00,49.99 L500.00,150.00 L0.00,150.00 Z" style="stroke: none; fill: #fff;"></path></svg></div>
            </div>
        </div>

        <div class="header">
            <div class="menu-bars center"><i class="fas fa-bars"></i></div>
            <div class="logo center">Huisjes.nl</div>
        </div>

        <div class="main">
            <div class="block">
                <div class="block-header">
                    Welkom!
                </div>
                <div class="block-main">
                    Zoek hier de perfecte accomodatie voor je vakantie:<br>
                    <form>
                        <input type="text" name="accomodation_name" placeholder="Naam van accomodatie..."/>
                        <input type="submit" value="Zoeken"/>
                    </form>
                </div>
            </div>

            <div class="block black">
                <div class="block-header">
                    Of laat ons tips geven
                </div>
                <div class="block-main">
                    <form>
                        <input type="date" name="date" placeholder="Wanneer ga je?"/>
                        <input type="number" name="date" placeholder="En met hoeveel personen?"/>
                        <input type="submit" value="Zoeken"/>
                    </form>
                </div>
            </div>
        </div>
    </body>

</html>