<html>
    <head></head>
    <body>
        <h3>Open Window Savenger Hunt</h3>
        <p>
            <?php
                $messages = array(
                                    "JcPFvMiyqmf3cEfW"=>"Message 1",
                                    "crif2nkrth647t0A"=>"Message 2",
                                    "AAMWFUmNgfiPQLj6"=>"Message 3",
                                    "DBIhu5CmyGkpQAaE"=>"Message 4",
                                    "sEPSsfILPBdWtolW"=>"Message 5",
                                    "Wcb4nHQ8WydYfTEZ"=>"Message 6",
                                    "vJRrYiVuEUJjEv7o"=>"Message 7",
                                    "j3gklUVCNhbNVurv"=>"Message 8",
                                    "Ib0nwmuL9v3xWilP"=>"Message 9",
                                    "Mys79mqUEF6sZ0nf"=>"Message 10"
                );
                
                $code = $_GET['code'];
            
                echo $message[$code];
            ?>
        </p>
    </body>
</html>