
<section class="oddsFilter-darkHover">
    <section class="oddsFilter-container">
        <a class="fa fa-times"></a>
        <h1><i class="fa fa-filter"></i> Filter</h1>
        <form method="get" class="oddsFilter">
            <article>
                <h2>Sports</h2>
                <div>
                    <?php
                    $SQLSPORTS = "SELECT * FROM sports_type WHERE active_stat = '1'";
                    $RESSPORTS = $_CON->query($SQLSPORTS);
                    while($ROWSPORTS = $RESSPORTS->fetch(PDO::FETCH_ASSOC)){
                        echo '<label><input type="checkbox" name="SPORTS[]" checked="checked" value="' . $ROWSPORTS['id'] . '"> ' . $ROWSPORTS['sports_type'] . '</label>';
                    }
                    ?>
                </div>
            </article>

            <article>
                <h2>Bookies</h2>
                <div>
                    <?php
                    $SQLBOOKIES = "SELECT * FROM bookies WHERE active_stat = '1'";
                    $RESBOOKIES = $_CON->query($SQLBOOKIES);
                    while($ROWBOOKIES = $RESBOOKIES->fetch(PDO::FETCH_ASSOC)){
                        echo '<label><input type="checkbox" name="BOOKIES[]" checked="checked" value="' . $ROWBOOKIES['id'] . '"> ' . $ROWBOOKIES['b_name'] . '</label>';
                    }
                    ?>
                </div>
            </article>

            <article>
                <h2>Exchange</h2>
                <div>
                    <?php
                    $SQLEXCHANGE = "SELECT * FROM exchanges WHERE active_stat = '1'";
                    $RESEXCHANGE = $_CON->query($SQLEXCHANGE);
                    while($ROWEXCHANGE = $RESEXCHANGE->fetch(PDO::FETCH_ASSOC)){
                        echo '<label><input type="checkbox" name="EXCHANGE[]" checked="checked" value="' . $ROWEXCHANGE['id'] . '" disabled> ' . $ROWEXCHANGE['ex_name'] . '</label>';
                    }
                    ?>
                </div>
            </article>

            <article id="rates_odds">
                <div>
                    <h2>Rates</h2>
                    <input type="text" name="MIN_RATE" placeholder="Min Rating">
                    <input type="text" name="MAX_RATE" placeholder="Max Rating">
                </div>

                <div>
                    <h2>Odds</h2>
                    <input type="text" name="MIN_ODDS" placeholder="Min Odds">
                    <input type="text" name="MAX_ODDS" placeholder="Max Odds">
                </div>

                <div>
                    <h2>Min Availability</h2>
                    <label id="avail-lbl">&euro;
                        <input type="text" name="AVAIL" placeholder="Min Availability" style="border: none; border-left: 1px solid #ccc; margin: 0 0 0 10px;">
                    </label>
                </div>
            </article>

            <div id="searchBox">
                <h2>Search Box</h2>
                <input type="text" name="" placeholder="Search">
                <span>
                    <input type="submit" name="" id="applyFilters" value="Apply Filters">
                    <input type="reset" name="" value="Reset Filters">
                </span>
                
            </div>
        </form>
    </section>
</section>