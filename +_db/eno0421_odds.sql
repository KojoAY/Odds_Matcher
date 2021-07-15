-- phpMyAdmin SQL Dump
-- version 4.7.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 08, 2017 at 07:04 PM
-- Server version: 10.1.29-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `eno0421_odds`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookies`
--

CREATE TABLE `bookies` (
  `id` int(100) NOT NULL,
  `b_name` varchar(150) NOT NULL,
  `b_url` tinytext NOT NULL,
  `b_image` varchar(50) NOT NULL,
  `add_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `active_stat` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bookies`
--

INSERT INTO `bookies` (`id`, `b_name`, `b_url`, `b_image`, `add_timestamp`, `active_stat`) VALUES
(1, 'Tipico', 'https://tipico.com/', 'images/tipico-logo.png', '2017-08-10 22:06:58', 1),
(2, 'Interwetten', 'https://www.interwetten.com/de/sportwetten/default.aspx', 'images/interwetten-logo.png', '2017-08-10 22:09:23', 1),
(3, 'Bet365', 'https://www.bet365.com/', '', '2017-08-10 22:09:23', 0),
(4, 'Betway', 'https://betway.com/de/', 'images/betway-logo.png', '2017-08-10 22:11:02', 1),
(5, '10bet', 'https://de.10bet.com/', '', '2017-08-10 22:15:09', 0),
(6, '888sport', 'https://www.888sport.com/de/', '', '2017-08-10 22:15:09', 0),
(7, 'Bet3000', 'https://www.bet3000.com/de/sportwetten', 'images/bet3000-logo.png', '2017-08-10 22:15:09', 1),
(8, 'Betfair', 'https://www.betfair.com/sport', '', '2017-08-10 22:15:09', 0),
(9, 'Betsafe', 'https://www.betsafe.com/de', 'images/betsafe-logo.jpg', '2017-08-10 22:15:09', 1),
(10, 'Big Bet World', 'https://www.bigbetworld.com/de/sportwetten', 'images/bigbetworld-logo.png', '2017-08-10 22:15:09', 1),
(11, 'Btty', 'https://btty.com/sportwetten/', '', '2017-08-10 22:15:09', 0),
(12, 'Bwin', 'https://www.bwin.com/de', 'images/bwin-logo.png', '2017-08-10 22:15:09', 1),
(13, 'Happybet', 'https://www.happybet.com/', '', '2017-08-10 22:15:09', 0),
(14, 'Mybet', 'https://mybet.com/de', 'images/mybet-logo.png', '2017-08-10 22:15:09', 1),
(15, 'Rivalo', 'https://www.rivalo.com/de/sportwetten/', '', '2017-08-10 22:17:13', 0),
(16, 'Sportingbet', 'https://sports.sportingbet.com/de/sports', 'images/sportingbet-logo.png', '2017-08-10 22:17:13', 1),
(17, 'Sunmaker', 'https://www.sunmaker.com/de/', '', '2017-08-10 22:17:56', 0),
(18, 'Unibet', 'https://www.unibet.de/', '', '2017-08-10 22:17:56', 0),
(19, 'Xtip', 'https://www.xtip.de/de/site/index.html', '', '2017-08-10 22:19:07', 0),
(20, 'Bet At Home', 'https://www.bet-at-home.com/de', '', '2017-08-10 22:19:07', 0),
(21, 'Tipbet', 'https://tipbet.com/de/online-sportwetten/', 'images/tipbet-logo.png', '2017-11-17 04:18:51', 1);

-- --------------------------------------------------------

--
-- Table structure for table `bookies_urls`
--

CREATE TABLE `bookies_urls` (
  `id` int(5) NOT NULL,
  `bookie_id` int(5) NOT NULL,
  `sports_type_id` int(5) NOT NULL,
  `bookie_urls` text NOT NULL,
  `add_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `active_stat` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bookies_urls`
--

INSERT INTO `bookies_urls` (`id`, `bookie_id`, `sports_type_id`, `bookie_urls`, `add_timestamp`, `active_stat`) VALUES
(1, 1, 1, 'football/germany/3-liga/g8343301/\nfootball/germany/dfb-cup/g43301/\nfootball/germany/2nd-bundesliga/g41301/\nfootball/germany/bundesliga/g42301/\nfootball/germany/1-bundesliga-season-bets/g673610/\nfootball/germany/cup-season-bets/g628410/\nfootball/germany/bayern-specials/g1447010/\nfootball/germany/hertha-bsc-specials/g1855110/\nfootball/international-clubs/uefa-super-cup/g680301/\nfootball/international-clubs/copa-libertadores/g309301/\nfootball/international-clubs/club-friendly-games/g86301/\nfootball/international-clubs/season-bets/g772010/\nfootball/international/euro-cup-women-final-round/g3293301/\nfootball/england/community-shield/g1307301/\nfootball/england/championship/g2301/\nfootball/england/efl-cup/g17301/\nfootball/england/premier-league/g1301/\nfootball/england/premier-league-season-bets/g1277210/\nfootball/england/cup-season-bets/g631310/\nfootball/spain/la-liga/g36301/\nfootball/spain/super-cup/g2305301/\nfootball/spain/la-liga-season-bets/g1824310/\nfootball/spain/la-liga-2-season-bets/g1824410/\nfootball/spain/cup-season-bets/g631810/\nfootball/italy/super-cup/g1377301/\nfootball/italy/serie-a/g33301/\nfootball/italy/serie-b/g34301/\nfootball/italy/coppa-italia/g35301/\nfootball/italy/coppa-italia-lega-pro-girone-a/g13656301/\nfootball/italy/coppa-italia-lega-pro-girone-c/g13658301/\nfootball/italy/coppa-italia-lega-pro-girone-d/g13659301/\nfootball/italy/coppa-italia-lega-pro-girone-e/g13660301/\nfootball/italy/coppa-italia-lega-pro-girone-f/g13661301/\nfootball/italy/coppa-italia-lega-pro-girone-g/g13662301/\nfootball/italy/serie-a-season-bets/g1824510/\nfootball/italy/serie-b-season-bets/g1839410/\nfootball/italy/cup-season-bets/g631910/\nfootball/france/ligue-1/g4301/\nfootball/austria/tipico-bundesliga/g29301/\nfootball/austria/erste-liga/g30301/\nfootball/champions-league/qualifying-round-playoff/g810610/\nfootball/champions-league/season-bets/g683610/\nfootball/turkey/super-cup/g4584301/\nfootball/turkey/super-lig/g62301/\nfootball/turkey/season-bets/g631710/\nfootball/europa-league/qualifying-round-playoff/g810910/\nfootball/europa-league/season-bets/g683510/\nfootball/germany-amateur/regionalliga-north/g44301/\nfootball/germany-amateur/regionalliga-northeast/g21301301/\nfootball/germany-amateur/regionalliga-southwest/g21300301/\nfootball/germany-amateur/regionalliga-west/g8364301/\nfootball/special/2nd-bundesliga-daily-specials/g1811110/\nfootball/special/ligue-1-daily-specials/g1821810/\nfootball/denmark/superligaen/g12301/\nfootball/denmark/1st-division/g13301/\nfootball/denmark/2nd-division-pulje-1/g45168301/\nfootball/denmark/2nd-division-pulje-3/g45170301/\nfootball/denmark/1st-division-season-bets/g1826810/\nfootball/portugal/primeira-liga/g52301/\nfootball/portugal/segunda-liga/g280301/\nfootball/portugal/primeira-liga-season-bets/g632410/\nfootball/netherlands/eredivisie/g39301/\nfootball/netherlands/eredivisie-season-bets/g1826910/\nfootball/belgium/first-division-a/g38301/\nfootball/belgium/first-division-b-first-stage/g54395301/\nfootball/sweden/allsvenskan/g24301/\nfootball/sweden/superettan/g27301/\nfootball/sweden/2nd-division-ostra-gotaland/g405301/\nfootball/sweden/2nd-division-norra-svealand/g3106301/\nfootball/sweden/2nd-division-norra-gotaland/g14775301/\nfootball/sweden/2nd-division-norrland/g409301/\nfootball/sweden/2nd-division-vastra-gotaland/g410301/\nfootball/sweden/2nd-division-sodra-svealand/g408301/\nfootball/norway/eliteserien/g5301/\nfootball/norway/1-division/g6301/\nfootball/norway/2nd-division-avd-2/g395301/\nfootball/norway/3rd-division-group-3/g433301/\nfootball/norway/3rd-division-group-4/g434301/\nfootball/norway/3rd-division-group-5/g435301/\nfootball/norway/3rd-division-group-6/g436301/\nfootball/norway/nm-cup/g123301/\nfootball/scotland/premier-league/g54301/\nfootball/scotland/league-cup/g982301/\nfootball/scotland/cup-season-bets/g1169110/\nfootball/brazil/brasilero-serie-a/g83301/\nfootball/brazil/brasilero-serie-b/g1449301/\nfootball/brazil/brasilero-serie-c-group-a/g27213301/\nfootball/brazil/brasilero-serie-c-group-b/g27214301/\nfootball/brazil/brasileiro-serie-d-knockout-stage/g59906301/\nfootball/brazil/u20-paulista-1st-division-group-2/g59671301/\nfootball/brazil/u20-paulista-1st-division-group-3/g59672301/\nfootball/brazil/u20-paulista-1st-division-group-4/g59673301/\nfootball/switzerland/super-league/g1060301/\nfootball/switzerland/challenge-league/g1061301/\nfootball/croatia/1-hnl/g48301/\nfootball/russia/premier-league/g53301/\nfootball/finland/veikkausliiga/g31301/\nfootball/finland/ykkonen/g527301/\nfootball/finland/kakkonen-group-a/g1204301/\nfootball/finland/kakkonen-group-c/g1202301/\nfootball/luxembourg/division-nationale/g1935301/\nfootball/mexico/primera-division-apertura/g28301/\nfootball/mexico/liga-de-ascenso-apertura/g1918301/\nfootball/mexico/u20-league-apertura/g11218301/\nfootball/usa/major-league-soccer/g18301/\nfootball/usa/united-soccer-league/g15763301/\nfootball/usa/national-women-s-soccer-league/g26540301/\nfootball/usa/north-american-soccer-league-fall-season/g25548301/\nfootball/czech-republic/1-liga/g49301/\nfootball/czech-republic/u21-bohemia-group/g61818301/\nfootball/czech-republic/u21-moravia-group/g61820301/\nfootball/czech-republic/fnl/g843301/\nfootball/slovenia/prvaliga/g94301/\nfootball/poland/ekstraklasa/g64301/\nfootball/poland/puchar-polski/g202301/\nfootball/poland/i-liga/g1427301/\nfootball/poland/3-league-gruppe-1/g1736510/\nfootball/poland/3-league-gruppe-3/g1738710/\nfootball/romania/liga-i/g219301/\nfootball/bulgaria/a-pfg/g232301/\nfootball/bulgaria/super-cup/g4647301/\nfootball/slovakia/superliga/g92301/\nfootball/slovakia/2-liga/g1375301/\nfootball/ukraine/premier-league/g384301/\nfootball/hungary/nb-i/g50301/\nfootball/hungary/nb-ii/g28609301/\nfootball/estonia/esiliiga/g8849301/\nfootball/lithuania/a-liga/g1260301/\nfootball/latvia/virsliga/g1279301/\nfootball/belarus/vysshaya-league/g616301/\nfootball/iceland/urvalsdeild/g102301/\nfootball/ireland/ireland-league-cup/g2150301/\nfootball/israel/league-cup-national-group-c/g54353301/\nfootball/israel/league-cup-premier-group-b/g54349301/\nfootball/israel/league-cup-premier-group-c/g54350301/\nfootball/armenia/premier-league/g3586301/\nfootball/serbia/superliga/g1107301/\nfootball/wales/season-bets/g1543710/\nfootball/uzbekistan/pfl/g4429301/\nfootball/kazakhstan/premier-league/g3103301/\nfootball/bolivia/liga-profesional-clausura/g17140301/\nfootball/costa-rica/primera-division-campeonato-invierno/g4713301/\nfootball/costa-rica/liga-de-ascenso/g503510/\nfootball/chile/primera-division-torneo-transicion/g24314301/\nfootball/chile/primera-b-torneo-transicion/g61476301/\nfootball/el-salvador/primera-division-apertura/g4714301/\nfootball/ecuador/serie-a-segunda-etapa/g1387301/\nfootball/ecuador/serie-b-segunda-etapa/g61467301/\nfootball/guatemala/liga-nacional-apertura/g4103301/\nfootball/honduras/liga-nacional-apertura/g17034301/\nfootball/colombia/primera-a-clausura/g19236301/\nfootball/colombia/primera-b-clausura/g61189301/\nfootball/panama/lpf-opening/g8567301/\nfootball/paraguay/primera-division-clausura/g16752301/\nfootball/paraguay/segunda-division/g13304301/\nfootball/peru/primera-division-apertura/g34467301/\nfootball/peru/segunda-division/g13431301/\nfootball/venezuela/primera-division-clausura/g17037301/\nfootball/australia/ffa-cup/g34979301/\nfootball/australia/npl-new-south-wales/g31300301/\nfootball/australia/npl-western-australia/g31499301/\nfootball/australia/npl-queensland/g31283301/\nfootball/australia/npl-capital-football/g31281301/\nfootball/australia/npl-nsw-premier-league/g31378301/\nfootball/australia/npl-tasmania/g31508301/\nfootball/australia/nsw-u20-league/g642810/\nfootball/australia/u20-queensland-national-premier-league/g27253301/\nfootball/australia/nsw-premier-league-2/g31302301/\nfootball/australia/a-league-season-bets/g1284210/\nfootball/new-zealand/chatham-cup/g1414610/\nfootball/japan/j-league/g82301/\nfootball/japan/j-league-2/g3034301/\nfootball/japan/japan-football-league/g1089110/\nfootball/china/chinese-super-league/g652301/\nfootball/china/china-league/g3583301/\nfootball/indonesia/indonesia-soccer-championship/g4113301/\nfootball/south-korea/k-league/g3284301/\nfootball/south-korea/k-league-challenge/g6230301/\nfootball/thailand/premier-league/g7157301/\nfootball/nigeria/premier-league/g9324301/', '2017-08-11 10:59:36', 1),
(7, 1, 2, 'tennis/atp/montreal-canada/g57041301/\ntennis/atp/grand-slam/g376710/\ntennis/atp/los-cabos-mexico/g57035301/\ntennis/atp/los-cabos-mexico-doubles/g57036301/\ntennis/wta/washington-usa/g57212301/\ntennis/wta/stanford-usa/g57215301/\ntennis/wta/stanford-usa-doubles/g57216301/\ntennis/wta/toronto-canada/g57218301/\ntennis/wta/grand-slam/g263110/\ntennis/wta/wta-tournament-winner/g1359810/\ntennis/challenger/biella-italy/g60963301/\ntennis/challenger/liberec-czech-republic/g60969301/\ntennis/challenger/segovia-spain/g60966301/\ntennis/challenger/chengdu-china/g60957301/\ntennis/davis-cup/season-bets/g274910/\ntennis/federation-cup/season-bets/g1057110/', '2017-08-11 23:44:28', 1),
(8, 1, 3, 'basketball/usa/wnba/g591301/\nbasketball/usa/season-bets/g680510/\nbasketball/international/european-championship-2017/g1467410/\nbasketball/international/season-bets/g727510/\nbasketball/international/fiba-asia-championship/g1860910/\nbasketball/australia/south-australia-premier-league-women/g13844301/\nbasketball/australia/qbl/g1128910/\nbasketball/australia/qbl-women/g1669310/\nbasketball/chile/liga-saesa/g1820810/\nbasketball/peru/liga-nacional/g801610/\nbasketball/el-salvador/liga-mayor-de-baloncesto/g1625510/\nbasketball/puerto-rico/superior-nacional/g568510/\nbasketball/bolivia/libobasquet/g1851410/\nbasketball/nicaragua/lnb/g1850310/', '2017-08-11 23:44:28', 1),
(9, 1, 4, 'american-football/usa/nfl/g47301/', '2017-08-11 23:44:28', 1),
(10, 1, 6, 'boxing/free-fighting/g11710/\nboxing/free-fighting/ultimate-fighting-championship/g11810/\nboxing/free-fighting/ultimate-fighting-championship-women/g916710/\nboxing/free-fighting/bellator/g335410/\nboxing/international/g3874414372492183147/\nboxing/international/matchups/g3874435544393876533/\nboxing/international/specials/g725610/', '2017-08-11 23:44:28', 1),
(11, 1, 7, 'ice-hockey/germany/g41201/\nice-hockey/germany/season-bets/g678310/\nice-hockey/international/iihf-world-championships/g731210/\nice-hockey/usa/season-bets/g634210/\nice-hockey/russia/season-bets/g643710/\nice-hockey/austria/season-bets/g1571910/\nice-hockey/switzerland/season-bets/g643510/\nice-hockey/finland/season-bets/g797510/\nice-hockey/sweden/season-bets/g643610/\nice-hockey/norway/season-bets/g1436110/', '2017-08-11 23:44:28', 1);

-- --------------------------------------------------------

--
-- Table structure for table `bookie_odds`
--

CREATE TABLE `bookie_odds` (
  `bk_id` int(100) NOT NULL,
  `bk_unique_code` varchar(50) NOT NULL,
  `bk_bookie_id` int(100) NOT NULL,
  `bk_sports_type_id` int(5) NOT NULL,
  `bk_date_time` varchar(20) NOT NULL,
  `bk_competition` tinytext NOT NULL,
  `bk_home_team` varchar(200) NOT NULL,
  `bk_away_team` varchar(200) NOT NULL,
  `bk_outcome_team` varchar(200) NOT NULL,
  `bk_outcome_backodds` float NOT NULL,
  `bk_home_backodds` float NOT NULL,
  `bk_away_backodds` float NOT NULL,
  `bk_draw_backodds` float NOT NULL,
  `bk_add_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bookie_scraping_files`
--

CREATE TABLE `bookie_scraping_files` (
  `id` int(11) NOT NULL,
  `bookie_id` int(100) NOT NULL,
  `sports_type_id` int(5) NOT NULL,
  `file_name` varchar(50) NOT NULL,
  `folder` varchar(50) NOT NULL,
  `add_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `active_stat` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bookie_sports_type`
--

CREATE TABLE `bookie_sports_type` (
  `id` int(11) NOT NULL,
  `bookie_id` int(100) NOT NULL,
  `sports_types` text NOT NULL,
  `add_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `active_stat` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dict_filter`
--

CREATE TABLE `dict_filter` (
  `id` int(100) NOT NULL,
  `bookie_list` text NOT NULL,
  `matchbook_list` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dict_filter`
--

INSERT INTO `dict_filter` (`id`, `bookie_list`, `matchbook_list`) VALUES
(1, 'Manchester United, Manchester Utd', 'Manchester United'),
(2, 'Tottenham Hotspur', 'Tottenham Hotspur'),
(3, 'FC Arsenal, Arsenal FC, Arsenal', 'Arsenal'),
(4, 'Swansea City', 'Swansea City'),
(5, 'Crystal Palace', 'Crystal Palace'),
(6, 'West Ham United, FC West Ham Utd., West Ham United FC, FC West Ham United, West Ham Utd, West Ham', 'West Ham'),
(7, 'FC Liverpool, Liverpool FC, Liverpool', 'Liverpool'),
(8, 'Huddersfield Town', 'Huddersfield Town'),
(9, 'FC Watford, Watford FC, Watford ', 'Watford'),
(10, 'Stoke City', 'Stoke City'),
(11, 'West Bromwich, West Bromwich Albion, West Bromwich Albion FC, FC West Bromwich Albion', 'West Bromwich Albion'),
(12, 'Manchester City', 'Manchester City'),
(13, 'AFC Bournemouth, Bournemouth', 'AFC Bournemouth'),
(14, 'FC Chelsea, Chelsea FC, Chelsea', 'Chelsea'),
(15, 'Brighton & Hove, Brighton & Hove Albion, Brighton and Hove Albion, Brighton and Hove', 'Brighton & Hove Albion'),
(16, 'Southampton FC, Southampton, FC Southampton', 'Southampton'),
(17, 'Leicester City, Leicester City FC, FC Leicester City', 'Leicester City'),
(18, 'FC Everton, Everton FC, Everton', 'Everton'),
(19, 'SV Sandhausen', 'SV Sandhausen'),
(20, 'FC St. Pauli, St. Pauli FC, FC Saint Pauli, Saint Pauli FC, St. Pauli, Saint Pauli', 'FC St. Pauli'),
(21, '1 FC Cologne, 1.FC Köln, 1. FC Köln, 1.FC KÃ¶ln, 1. FC KÃ¶ln, 1. FC Cologne, 1.FC Cologne, 1 FC KÃ¶ln, 1 FC Köln', '1. FC KÃ¶ln'),
(22, '1 FC Kaiserslautern, 1 Kaiserslautern FC, FC Kaiserslautern, Kaiserslautern FC, 1. FC Kaiserslautern, 1.FC Kaiserslautern, 1. Kaiserslautern FC, 1.Kaiserslautern FC', '1. FC Kaiserslautern'),
(23, '1 FSV Mainz 05, 1. FSV Mainz 05, FSV Mainz 05', '1. FSV Mainz 05'),
(24, '1899 Hoffenheim', '1899 Hoffenheim'),
(25, 'Bayer Leverkusen, Bayer 04 Leverkusen', 'Bayer 04 Leverkusen'),
(26, 'Bayern Munich, FC Bayern München, Bayern MÃ¼nchen, FC Bayern MÃ¼nchen, FC Bayern Munich', 'Bayern MÃ¼nchen'),
(27, 'Borussia Dortmund', 'Borussia Dortmund'),
(28, 'Dynamo Dresden', 'Dynamo Dresden'),
(29, 'Eintracht Frankfurt', 'Eintracht Frankfurt'),
(30, 'FC Augsburg, Augsburg FC', 'FC Augsburg'),
(31, 'FC Schalke 04, Schalke 04 FC, Schalke 04', 'FC Schalke 04'),
(32, 'Hamburger SV', 'Hamburger SV'),
(33, 'Hannover 96', 'Hannover 96'),
(34, 'Hertha BSC', 'Hertha BSC'),
(35, 'Monchengladbach, Borussia Mönchengladbach, Borussia MÃ¶nchengladbach, Borussia M\'gladbach, MÃ¶nchengladbach', 'Borussia MÃ¶nchengladbach'),
(36, 'RB Leipzig', 'RB Leipzig'),
(37, 'SC Freiburg', 'SC Freiburg'),
(38, 'VfB Stuttgart', 'VfB Stuttgart'),
(39, 'VfL Wolfsburg', 'VfL Wolfsburg'),
(40, 'Newcastle United, Newcastle Utd', 'Newcastle United'),
(42, 'FC Burnley, Burnley FC, Burnley', 'Burnley'),
(44, 'AC Lugano, Lugano AC, FC Lugano, Lugano FC, Lugano', 'FC Lugano'),
(45, 'AC Mailand, AC Milan', 'AC Milan'),
(46, 'AEK Athen, AEK Athens, AEK Athen FC, AEK Athen FC', 'AEK Athens'),
(47, 'Apollon Limassol, Apollon Limassol FC, FC Apollon Limassol, Apoll. Limassol', 'Apollon Limassol'),
(48, 'Atalanta Bergamo, Atalanta', 'Atalanta'),
(49, 'Austria Wien FK, FK Austria Wien, Austria Wien', 'FK Austria Wien'),
(50, 'Basaksehir FK, Istanbul Basaksehir FK', 'Istanbul Basaksehir FK'),
(51, 'BATE Borisov, FC BATE Borisov, BATE Borisov FC, BATE Borisow,  FC BATE Borisow', 'FC BATE Borisov'),
(52, 'FC Astana, Astana FC, Astana', 'FC Astana'),
(53, 'FC Dynamo Kiew, Dynamo Kiew FC, Dynamo Kyiv, FC Dynamo Kyiv, Dynamo Kyiv FC, FC Dynamo Kiev, Dynamo Kiev', 'Dynamo Kyiv'),
(56, 'FC S. Bukarest, S. Bukarest FC, FC Steaua Bucuresti, Steaua Bucuresti FC, Steaua Bucuresti, FCSB, Fotbal Club Fcsb', 'Steaua Bucuresti'),
(57, 'FC Sheriff Tiraspol, Sheriff Tiraspol FC, Sheriff Tiraspol', 'Sheriff Tiraspol'),
(58, 'FC Villarreal, Villarreal FC, Villarreal', 'Villarreal'),
(59, 'Hapoel Beer Sheva, Hapoel Be\'er Sheva', 'Hapoel Be\'er Sheva'),
(60, 'HNK Rijeka', 'HNK Rijeka'),
(61, 'Konyaspor, Atiker Konyaspor 1922, Atiker Konyaspor, Konyaspor 1922', 'Konyaspor'),
(62, 'Lazio Rom, Lazio Roma, Lazio', 'Lazio'),
(63, 'Ludogorets Razgrad, PFC Ludogorets, PFC Ludogorets Razgrad', 'Ludogorets Razgrad'),
(64, 'Macc. Tel-Aviv, Maccabi Tel-Aviv, Macc. Tel Aviv, Maccabi Tel Aviv, Macc Tel-Aviv, Macc Tel Aviv', 'Maccabi Tel Aviv'),
(65, 'OGC Nizza, Nizza OGC, OGC Nice, Nice OGC', 'OGC Nice'),
(66, 'Olymp. Marseille, Olympique Marseille', 'Olympique Marseille'),
(67, 'Olympique Lyon, Olympique Lyonnais', 'Olympique Lyonnais'),
(68, 'Lok Moskau, Lok. Moskau, Lokomotiv Moskau, Lokomotiv Moscow, Lok Moscow, Lok. Moscow, Lokomotive Moskau, Lokomotive Moscow, FC Lokomotiv Moscow, FC Lokomotive Moscow, Lok Moskau', 'Lokomotiv Moscow'),
(69, 'FK Partizan, Partizan FK, Partizan Belgrad, FK Partizan Belgrad, Partizan, Partizan Belgrade, FK Partizan Belgrade', 'FK Partizan'),
(70, 'FC RB Salzburg, RB Salzburg FC, FC Red Bull Salzburg, Red Bull Salzburg FC, Red Bull Salzburg, RB Salzburg', 'FC Red Bull Salzburg'),
(71, 'Real Sociedad', 'Real Sociedad'),
(72, 'Rosenborg, Rosenborg BK, Rosenborg Trondheim', 'Rosenborg BK'),
(73, 'SC Braga, Braga SC, Sporting de Braga, Sporting Braga', 'Sporting de Braga'),
(75, 'Slavia Prag, SK Slavia Praha, SK Slavia Prag', 'SK Slavia Praha'),
(76, 'Vardar Skopje, FK Vardar Skopje, Vardar Skopje FK, FK Vardar', 'FK Vardar'),
(77, 'FC Viktoria Pilsen, Viktoria Pilsen FC, FC Viktoria Plzen, Viktoria Plzen FC, Viktoria Pilsen, Viktoria Plzen', 'FC Viktoria Plzen'),
(78, 'Vit. Guimaraes, Vitoria Guimaraes, Vit Guimaraes, Vit. de Guimaraes, Vit de Guimaraes, Vitoria de Guimaraes', 'Vitoria de Guimaraes'),
(79, 'Vitesse Arnheim, Vitesse Arnhem, SBV Vitesse', 'Vitesse'),
(80, 'Young Boys Bern, BSC Young Boys', 'BSC Young Boys'),
(81, 'Zenit St. Petersburg, Zenit Saint-Petersburg, Zenit Saint Petersburg, FC Zenit St Petersburg', 'Zenit Saint-Petersburg'),
(82, 'Zulte Waregem, Zulte-Waregem, SV Zulte Waregem, SV Zulte-Waregem', 'Zulte Waregem'),
(83, 'Juventus Turin, Juventus', 'Juventus'),
(84, 'FC Barcelona, Barcelona FC, FC Barcelona B', 'FC Barcelona'),
(85, 'Sporting CP, Sporting Lissabon', 'Sporting CP'),
(86, 'Olympiakos P., Olympiakos PirÃ¤us, Olympiacos, Olympiakos Piräus', 'Olympiacos'),
(87, 'FK Qarabag, Qarabag FK', 'FK Qarabag'),
(89, 'AS Rom, AS Roma', 'AS Roma'),
(90, 'Celtic Glasgow, Celtic, Celtic FC, FC Celtic, FC Celtic Glasgow', 'Celtic'),
(91, 'Paris SG, Paris Saint-Germain', 'Paris Saint-Germain'),
(92, 'Anderlecht, RSC Anderlecht', 'Anderlecht'),
(94, 'ZSKA Moskau, CSKA Moscow, CSKA Moskau, ZSKA Moscow, PFC CSKA Moscow', 'CSKA Moscow'),
(95, 'Benfica, Benfica Lissabon', 'Benfica'),
(96, 'FC Basel, Basel FC, Basel', 'FC Basel'),
(98, 'Roter Stern Belgrad, Crvena Zvezda, FK Roter Stern, Roter Stern FK, Roter Stern, Red Star Belgrade', 'Crvena Zvezda'),
(99, 'Athletic Bilbao', 'Athletic Bilbao'),
(101, 'FC Zorya Lugansk, Zorya Lugansk FC, FC Zorya Luhansk, Zorya Luhansk', 'Zorya Luhansk'),
(104, 'Stade Rennes, Stade Rennais, Stade Rennais FC, FC Stade Rennais, Stade Rennes FC, FC Stade Rennes', 'Stade Rennais'),
(105, 'FC Nantes, Nantes FC, Nantes', 'FC Nantes'),
(106, 'Dijon FCO', 'Dijon FCO'),
(107, 'FC Toulouse, Toulouse FC', 'Toulouse FC'),
(108, 'FC Metz, Metz FC', 'FC Metz'),
(109, 'SC Amiens, Amiens SC', 'Amiens SC'),
(110, 'HSC Montpellier, Montpellier HSC', 'Montpellier HSC'),
(111, 'OSC Lille, Lille OSC', 'Lille OSC'),
(112, 'SM Caen', 'SM Caen'),
(113, 'Bordeaux, Girondins de Bordeaux, FC Girondins Bordeaux, Girondins Bordeaux, FC Girondins de Bordeaux, FC Bordeaux', 'Girondins de Bordeaux'),
(114, 'Troyes AC, Estac Troyes', 'Troyes AC'),
(115, 'SCO Angers, Angers SCO', 'Angers SCO'),
(117, 'EA Guingamp, En Avant Guingamp, En Avant de Guingamp', 'En Avant Guingamp'),
(118, 'AS Monaco', 'AS Monaco'),
(119, 'FC Bologna, Bologna FC, Bologna', 'Bologna'),
(120, 'Sampdoria Genua. Sampdoria', 'Sampdoria'),
(121, 'Chievo Verona, Chievo, AC Chievo Verona', 'Chievo'),
(122, 'Spal 2013, SPAL', 'SPAL'),
(123, 'US Sassuolo, Sassuolo', 'Sassuolo'),
(124, 'Hellas Verona', 'Hellas Verona'),
(125, 'Cagliari Calcio, Cagliari', 'Cagliari'),
(126, 'Inter Mailand', 'Internazionale'),
(128, 'AC Torino, Torino', 'Torino'),
(129, 'Genua FC, FC Genua, Genoa, Genoa FC, FC Genoa, Genoa CFC, Genua', 'Genoa'),
(131, 'Udinese Calcio', 'Udinese'),
(132, 'SSC Neapel, SSC Napoli, Napoli, SSC Neapel, Neapel', 'Napoli'),
(134, 'AC Florenz, Florenz AC, FC Florenz, Fiorentina, ACF Fiorentina', 'Fiorentina'),
(136, 'FC Crotone, Crotone FC, Crotone', 'Crotone'),
(138, 'Benevento Calcio, Benevento', 'Benevento'),
(139, 'Celta de Vigo, Celta Vigo', 'Celta de Vigo'),
(140, 'CD Leganes, CD Leganã‰s, Leganes, Leganés, CD Leganés, Leganã‰s', 'Leganã‰s'),
(141, 'Alaves, Deportivo Alaves, CD Alaves', 'Deportivo Alaves'),
(142, 'SD Eibar, Eibar', 'SD Eibar'),
(143, 'Real Madrid', 'Real Madrid'),
(144, 'FC Malaga, Malaga FC, MÃ¡laga FC, FC MÃ¡laga, Malaga, Málaga, FC Málaga, MÃ¡laga', 'MÃ¡laga'),
(145, 'Betis Sevilla, Real Betis, Real Betis Sevilla, Real Betis Balompie', 'Real Betis'),
(146, 'Girona CF, Girona, FC Girona', 'Girona'),
(147, 'UD Levante, Levante UD, Levante', 'Levante UD'),
(148, 'Atletico Madrid, AtlÃ©tico de Madrid, Atletico Madrid, AtlÃ©tico Madrid, Atlã‰tico de Madrid, Atlã‰tico Madrid, Atlético de Madrid, Atlético Madrid', 'Atlã‰tico de Madrid'),
(150, 'Deportivo La Coruña, Deportivo La Coruna', 'Deportivo La Coruña'),
(153, 'UD Las Palmas', 'UD Las Palmas'),
(155, 'FC Sevilla, Sevilla FC, Sevilla', 'Sevilla'),
(156, 'FC Valencia, Valencia FC, Valencia', 'Valencia'),
(159, 'Bayern Munich, FC Bayern München, Bayern MÃ¼nchen, FC Bayern MÃ¼nchen, FC Bayern Munich, FC Bayern München, Bayern München', 'FC Bayern MÃ¼nchen'),
(164, 'Rac. Straßburg , Racing Strasbourg, Rac. StraÃŸburg, Racing StraÃŸburg, Rac. Strasbourg, Racing Straßburg, RC Straßburg , RC Strasbourg, RC StraÃŸburg, RC StraÃŸburg, RC Strasbourg, RC Straßburg', 'RC Strasbourg'),
(165, 'AtlÃ©tico de Madrid, Atletico Madrid, AtlÃ©tico Madrid', 'AtlÃ©tico de Madrid'),
(170, 'Skenderbeu Korce, KS SkÃ«nderbeu KorÃ§Ã«, KS Skënderbeu Korçë', 'KS SkÃ«nderbeu KorÃ§Ã«'),
(172, 'FC Fastav ZlÃ­-­n, Fastav ZlÃ-­n FC, FC Fastav Zlin, Fastav Zlin FC, Fastav Zlin, FC Fastav Zlín, Fastav Zlín, Fastav Zlin', 'FC Fastav ZlÃ­-n'),
(174, 'Ã–stersunds FK, Östersunds FK', 'Ã–stersunds FK'),
(177, 'FC Kopenhagen, FC KÃ¸benhavn, FC København, Kopenhagen FC, KÃ¸benhavn FC', 'FC KÃ¸benhavn'),
(181, 'AS Saint Etienne, Saint-Ã‰tienne, AS Saint-Ã‰tienne, Saint Etienne, AS Saint-Étienne, AS Saint-Ã‰tienne, Saint-Étienne', 'Saint-Ã‰tienne'),
(182, 'Roter Stern Belgrad, Crvena Zvezda, FK Roter Stern, Roter Stern FK', 'Roter Stern'),
(183, 'Roter Stern Belgrad, Crvena Zvezda, FK Roter Stern, Roter Stern FK', 'FK Roter Stern'),
(184, 'Roter Stern Belgrad, Crvena Zvezda, FK Roter Stern, Roter Stern FK', 'Roter Stern Belgrad'),
(185, '1. FC Heidenheim', '1. FC Heidenheim'),
(186, '1.FC NÃ¼rnberg, 1. FC NÃ¼rnberg, 1. FC Nürnberg', '1. FC NÃ¼rnberg'),
(187, '1. FC Union Berlin, FC Union Berlin', '1. FC Union Berlin'),
(188, '1. FC Nuremberg', '1. FC Nuremberg'),
(189, 'Albacete Balompiã‰, Albacete Balompie', 'Albacete Balompiã‰'),
(190, 'AD Alcorcon, Alcorcón, AD Alcorcón', 'Alcorcón'),
(191, 'Apoel Nicosia FC, APOEL', 'APOEL'),
(192, 'Arminia Bielefeld', 'Arminia Bielefeld'),
(193, 'Besiktas JK, Besiktas', 'Besiktas JK'),
(194, 'Cádiz, Cadiz CF, CÃ¡diz, CÃ¡diz FC', 'CÃ¡diz'),
(195, 'CD Numancia', 'CD Numancia'),
(196, 'CD Tenerife', 'CD Tenerife'),
(197, 'CF Reus Deportiu', 'CF Reus Deportiu'),
(198, 'Cultural Leonesa', 'Cultural Leonesa'),
(199, 'Eintracht Braunschweig, Eintr. Braunschweig', 'Eintracht Braunschweig'),
(200, 'Espanyol, RCD Espanyol, Espanyol Barcelona', 'Espanyol'),
(201, 'FC Barcelona, Barcelona FC, FC Barcelona B', 'FC Barcelona B'),
(202, 'FC Erzgebirge Aue, Erzgebirge Aue', 'FC Erzgebirge Aue'),
(203, 'FC Ingolstadt, FC Ingolstadt 04', 'FC Ingolstadt 04'),
(204, 'FC Porto, Porto', 'FC Porto'),
(205, 'Feyenoord Rotterdam, Feyenoord', 'Feyenoord'),
(206, 'Fortuna Düsseldorf, Fortuna Dusseldorf, Fortuna DÃ¼sseldorf', 'Fortuna DÃ¼sseldorf'),
(207, 'FK Austria Wien, Austria Wien, Austria Wien FK', 'FX Austria Wien'),
(208, 'FC Getafe, Getafe', 'Getafe'),
(209, 'Gimnastic de Tarragona', 'Gimnastic de Tarragona'),
(210, 'FC Granada, Granada FC, Granada', 'Granada FC'),
(211, 'Holstein Kiel', 'Holstein Kiel'),
(212, 'Huesca, SD Huesca', 'Huesca'),
(213, 'Lorca CF, Lorca FC', 'Lorca FC'),
(214, 'CD Lugo, Lugo', 'Lugo'),
(215, 'MSV Duisburg', 'MSV Duisburg'),
(216, 'Newcastle United Jets', 'Newcastle United Jets'),
(217, 'NK Maribor', 'NK Maribor'),
(218, 'CA Osasuna', 'Osasuna'),
(219, 'Rayo Vallecano', 'Rayo Vallecano'),
(220, 'Real Oviedo', 'Real Oviedo'),
(221, 'Sporting Gijon, Real Sporting de Gijon', 'Real Sporting de Gijon'),
(222, 'Real Valladolid', 'Real Valladolid'),
(223, 'Real Saragossa, Real Zaragoza', 'Real Zaragoza'),
(224, 'Sevilla Atletico, Sevilla Atlético, Sevilla Atlã‰tico', 'Sevilla Atletico'),
(225, 'Schachtar Donezk, FC Schachtar Donezk, Shakhtar Donetsk, FC Shakhtar Donetsk, Schachtjor Donezk, FC Schachtjor Donezk', 'Shakhtar Donetsk'),
(226, 'FC Spartak Moscow, Spartak Moskau, FC Spartak Moskau, Spartak Moscow', 'Spartak Moscow'),
(227, 'Greuther Fürth, SpVgg Greuther Fürth, Greuther Furth, Greuther FÃ¼rth, SpVgg Greuther FÃ¼rth', 'SpVgg Greuther FÃ¼rth'),
(228, 'Jahn Regensburg, SSV Jahn Regensburg', 'SSV Jahn Regensburg'),
(229, 'SV Darmstadt 98', 'SV Darmstadt 98'),
(230, 'UD Almería, UD Almeria, UD AlmerÃ­a', 'UD AlmerÃ­a'),
(231, 'VfL Bochum', 'VfL Bochum'),
(232, 'Werder Bremen, SV Werder Bremen', 'Werder Bremen');

-- --------------------------------------------------------

--
-- Table structure for table `exchanges`
--

CREATE TABLE `exchanges` (
  `id` int(100) NOT NULL,
  `ex_name` varchar(150) NOT NULL,
  `ex_url` tinytext NOT NULL,
  `add_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `active_stat` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `exchanges`
--

INSERT INTO `exchanges` (`id`, `ex_name`, `ex_url`, `add_timestamp`, `active_stat`) VALUES
(1, 'Matchbook', 'https://www.matchbook.com/', '2017-11-17 04:12:18', 1);

-- --------------------------------------------------------

--
-- Table structure for table `exchange_odds`
--

CREATE TABLE `exchange_odds` (
  `ex_id` int(100) NOT NULL,
  `ex_unique_code` varchar(50) NOT NULL,
  `ex_exchange_id` int(100) NOT NULL,
  `ex_sports_type_id` int(5) NOT NULL,
  `ex_date_time` varchar(20) NOT NULL,
  `ex_competition` tinytext NOT NULL,
  `ex_home_team` varchar(200) NOT NULL,
  `ex_away_team` varchar(200) NOT NULL,
  `ex_outcome_team` varchar(200) NOT NULL,
  `ex_home_layodds` float NOT NULL,
  `ex_away_layodds` float NOT NULL,
  `ex_draw_layodds` float NOT NULL,
  `ex_outcome_layodds` float NOT NULL,
  `ex_layodds_stake` float NOT NULL,
  `ex_qualifying_loss` float NOT NULL,
  `ex_home_available` float NOT NULL,
  `ex_away_available` float NOT NULL,
  `ex_draw_available` float NOT NULL,
  `ex_outcome_available` float NOT NULL,
  `ex_add_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `exchange_scraping_files`
--

CREATE TABLE `exchange_scraping_files` (
  `id` int(11) NOT NULL,
  `exchange_id` int(100) NOT NULL,
  `sports_type_id` int(5) NOT NULL,
  `file_name` varchar(50) NOT NULL,
  `folder` varchar(50) NOT NULL,
  `add_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `active_stat` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `exchange_sports_type`
--

CREATE TABLE `exchange_sports_type` (
  `id` int(11) NOT NULL,
  `exchange_id` int(100) NOT NULL,
  `sports_types` text NOT NULL,
  `add_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `active_stat` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sports_type`
--

CREATE TABLE `sports_type` (
  `id` int(100) NOT NULL,
  `sports_type` varchar(150) NOT NULL,
  `add_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `active_stat` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sports_type`
--

INSERT INTO `sports_type` (`id`, `sports_type`, `add_timestamp`, `active_stat`) VALUES
(1, 'Fussball', '2017-08-10 22:42:12', 1),
(2, 'Tennis', '2017-08-10 22:42:12', 1),
(3, 'Basketball', '2017-08-10 22:42:12', 1),
(4, 'American Football', '2017-08-10 22:42:12', 1),
(5, 'Pferderennen', '2017-08-10 22:42:12', 1),
(6, 'Boxen', '2017-08-10 22:42:12', 1),
(7, 'Eishockey', '2017-08-10 22:42:12', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_account`
--

CREATE TABLE `user_account` (
  `id` int(100) NOT NULL,
  `fname` varchar(150) NOT NULL,
  `lname` varchar(150) NOT NULL,
  `email` tinytext NOT NULL,
  `password` varchar(100) NOT NULL,
  `confirm_acc` varchar(50) NOT NULL,
  `service_plan` varchar(100) NOT NULL,
  `plan_datetime` varchar(20) NOT NULL,
  `prev_plan` varchar(100) NOT NULL,
  `prev_plan_datetime` varchar(20) NOT NULL,
  `add_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `active_stat` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookies`
--
ALTER TABLE `bookies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bookies_urls`
--
ALTER TABLE `bookies_urls`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bookie_odds`
--
ALTER TABLE `bookie_odds`
  ADD PRIMARY KEY (`bk_id`);

--
-- Indexes for table `bookie_scraping_files`
--
ALTER TABLE `bookie_scraping_files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bookie_sports_type`
--
ALTER TABLE `bookie_sports_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dict_filter`
--
ALTER TABLE `dict_filter`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exchanges`
--
ALTER TABLE `exchanges`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exchange_odds`
--
ALTER TABLE `exchange_odds`
  ADD PRIMARY KEY (`ex_id`);

--
-- Indexes for table `exchange_scraping_files`
--
ALTER TABLE `exchange_scraping_files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exchange_sports_type`
--
ALTER TABLE `exchange_sports_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sports_type`
--
ALTER TABLE `sports_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_account`
--
ALTER TABLE `user_account`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookies`
--
ALTER TABLE `bookies`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `bookies_urls`
--
ALTER TABLE `bookies_urls`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `bookie_odds`
--
ALTER TABLE `bookie_odds`
  MODIFY `bk_id` int(100) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `bookie_scraping_files`
--
ALTER TABLE `bookie_scraping_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `bookie_sports_type`
--
ALTER TABLE `bookie_sports_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `dict_filter`
--
ALTER TABLE `dict_filter`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=233;
--
-- AUTO_INCREMENT for table `exchanges`
--
ALTER TABLE `exchanges`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `exchange_odds`
--
ALTER TABLE `exchange_odds`
  MODIFY `ex_id` int(100) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `exchange_scraping_files`
--
ALTER TABLE `exchange_scraping_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `exchange_sports_type`
--
ALTER TABLE `exchange_sports_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sports_type`
--
ALTER TABLE `sports_type`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `user_account`
--
ALTER TABLE `user_account`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
