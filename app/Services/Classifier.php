<?php
/**
 * Created by PhpStorm.
 * User: MANAR
 * Date: 08/07/2018
 * Time: 05:58 م
 */

namespace App\Services;


use App\Analysis;
use App\Entity;
use App\Mining;
use App\Post;
use Illuminate\Support\Facades\DB;

class Classifier
{
    function expandName($productName){
        echo $productName;
    }

    public static $priceSimilars =       ['price','free','amount','bill','cost','demand','discount','estimate','expenditure','expense','fare','fee','figure','output','pay','payment','premium','rate','return','tariff','valuation','worth','appraisal','assessment','barter','bounty','ceiling','charge','compensation','consideration','damage','disbursement','dues','exaction','hire','outlay','prize','quotation','ransom','reckoning','retail','reward','score','sticker','tab','ticket','toll','tune','wages','wholesale','appraisement','asking price','face value','evaluate','fix','mark down','mark up','put a price on','reduce','currency','money','capital','cash','check','fund','property','salary','wage','wealth','banknote','bankroll','bread','bucks','coin','coinage','finances','funds','gold','greenback','loot','resources','riches','roll','silver','specie','treasure','almighty dollar','hard cash','legal tender','medium of exchange','excise','levy','tax','impost','price tag','budget','consumption','debt','insurance','investment','loan','loss','mortgage','obligation','payroll','spending','sum  ','bite','debit','decrement','deprivation','forfeit','forfeiture','outdo','overhead','surcharge','upkeep','bottom line','out of pocket','buck','note','refund','reserve','security','stock','supply','bullion','cabbage','dinero','dough','lot','pledge','principal','remuneration','savings','scratch','skins','wampum','wherewithal','chicken feed','green stuff','legal tender','mazumah','ready assets','','conservation','preservation','repair','costs','expenses','keep','running','subsistence','support','sustenance','sustentation','aid','alimony','allocation','allotment','annuity','contribution','gift','grant','pension','quota','ration','scholarship','stipend','subsidy','apportionment','bequest','commission','cut','endowment','fellowship','honorarium','inheritance','interest','legacy','measure','part','piece','portion','quantity','recompense','remittance','share','slice','stint','taste','credit'] ;
    public static $productSimilars =       ['product','amount','brand','commodity','crop','device','fruit','merchandise','output','produce','production','profit','stock','work','aftermath','artifact','blend','brew','by-product','compound','concoction','confection','consequence','contrivance','creation','decoction','effect','emolument','fabrication','gain','handiwork','invention','issue','legacy','line','manufacture','offshoot','outcome','outgrowth','preparation','realization','result','returns','synthetic','upshot','yield','spinoff','character','quality','variety','cast','class','description','grade','make','sort','species','aspect','condition','element','kind','nature','trait','affection','affirmation','attribute','constitution','endowment','essence','factor','genius','individuality','mark','parameter','peculiarity','predication','property','savor','virtue','name of tune','nature of beast','attitude','facet','form','appearance','bearing','countenance','demeanor','expression','face','look','manner','mien','certificate','assurance','bail','bond','contract','covenant','guarantee','guaranty','pledge','security','surety','written promise','','care','freedom','insurance','preservation','surveillance','aegis','agreement','armament','armor','asylum','collateral','compact','cover','custody','defense','earnest','guard','immunity','pact','pawn','precaution','redemption','refuge','retreat','safeguard','safekeeping','safeness','salvation','sanctuary','shelter','shield','token','ward','warrant','safety measure','equity','estate','farm','goods','home','house','land','ownership','plot','tract','wealth','worth','acreage','acres','assets','belongings','buildings','capital','chattels','claim','dominion','effects','freehold','holdings','inheritance','means','premises','proprietary','proprietorship','realty','resources','riches','substance','title','possessorship','features','lineaments','looks','','mug','physiognomy','puss','visage','bind','bundle','collect','gather','load','store','stow','batch','brace','bunch','burden','dispose','fasten','package','tie','warehouse','get ready','put in order','account','assistance','benefit','business','duty','employment','maintenance','office','supply','use','utility','','advantage','applicability','appropriateness','avail','check','courtesy','dispensation','employ','favor','fitness','indulgence','kindness','labor','ministration','overhaul','relevance','serviceability','servicing','usefulness','value','circuition','life-cycle'];//1736
    public static $sentimetScales = array("1"=>"very nigative", "2"=>"nigative","3"=>"natural","4"=>"positive","5"=>"very positive");
    //private static $randomizedCountries =[ 9 , 18 , 187 , 31 , 31 , 187 , 87 , 21 , 31 , 31 , 187 , 18 , 9 , 187 , 31 , 187 , 31 , 187 , 187 , 31 , 187 , 17 , 187 , 114 , 114 , 31 , 21 , 31 , 66 , 9 , 187 , 187 , 66 , 64 , 90 , 114 , 187 , 18 , 24 , 187 , 187 , 187 , 66 , 24 , 8 , 187 , 31 , 31 , 127 , 64 , 60 , 31 , 91 , 7 , 31 , 187 , 107 , 11 , 24 , 17 , 31 , 187 , 187 , 187 , 156 , 187 , 60 , 187 , 11 , 31 , 187 , 187 , 187 , 187 , 24 , 187 , 187 , 31 , 8 , 187 , 31 , 187 , 187 , 60 , 187 , 9 , 31 , 187 , 31 , 187 , 187 , 31 , 187 , 8 , 187 , 31 , 187 , 76 , 36 , 64 , 9 , 52 , 187 , 187 , 87 , 187 , 31 , 187 , 11 , 36 , 17 , 31 , 187 , 187 , 172 , 60 , 9 , 114 , 18 , 187 , 187 , 187 , 18 , 187 , 187 , 31 , 196 , 37 , 187 , 76 , 187 , 187 , 31 , 187 , 187 , 187 , 9 , 187 , 7 , 24 , 31 , 187 , 187 , 9 , 1 , 187 , 187 , 76 , 36 , 189 , 187 , 187 , 8 , 127 , 187 , 187 , 187 , 114 , 9 , 76 , 187 , 187 , 31 , 31 , 187 , 31 , 127 , 187 , 36 , 18 , 31 , 187 , 3 , 3 , 187 , 36 , 66 , 36 , 76 , 9 , 31 , 187 , 9 , 187 , 187 , 21 , 187 , 127 , 31 , 2 , 9 , 36 , 187 , 9 , 187 , 36 , 87 , 36 , 64 , 187 , 64 , 31 , 187 , 187 , 172 , 187 , 9 , 36 , 36 , 31 , 60 , 187 , 64 , 31 , 187 , 21 , 18 , 31 , 180 , 31 , 60 , 36 , 24 , 36 , 36 , 187 , 187 , 17 , 187 , 31 , 187 , 187 , 60 , 31 , 187 , 187 , 37 , 31 , 31 , 180 , 187 , 18 , 9 , 114 , 76 , 36 , 31 , 37 , 36 , 31 , 36 , 187 , 187 , 60 , 187 , 186 , 187 , 24 , 76 , 187 , 9 , 7 , 36 , 36 , 187 , 31 , 31 , 187 , 18 , 187 , 76 , 9 , 21 , 64 , 9 , 187 , 187 , 36 , 36 , 31 , 187 , 9 , 187 , 31 , 187 , 187 , 187 , 187 , 24 , 31 , 187 , 60 , 186 , 187 , 36 , 11 , 36 , 18 , 31 , 31 , 91 , 187 , 31 , 187 , 76 , 31 , 37 , 7 , 187 , 187 , 11 , 9 , 31 , 187 , 187 , 187 , 22 , 76 , 36 , 31 , 187 , 18 , 76 , 36 , 180 , 76 , 180 , 187 , 187 , 64 , 187 , 187 , 21 , 21 , 187 , 187 , 187 , 187 , 66 , 127 , 60 , 31 , 21 , 187 , 9 , 187 , 187 , 187 , 18 , 9 , 186 , 31 , 31 , 64 , 187 , 76 , 31 , 187 , 36 , 127 , 31 , 64 , 36 , 187 , 187 , 76 , 187 , 187 , 187 , 17 , 17 , 9 , 187 , 187 , 187 , 187 , 187 , 36 , 31 , 187 , 187 , 66 , 31 , 187 , 8 , 187 , 18 , 9 , 17 , 187 , 7 , 187 , 187 , 180 , 18 , 36 , 36 , 36 , 60 , 18 , 187 , 187 , 187 , 18 , 31 , 31 , 24 , 31 , 76 , 36 , 187 , 17 , 127 , 31 , 9 , 171 , 17 , 31 , 31 , 36 , 31 , 187 , 187 , 31 , 187 , 9 , 187 , 187 , 187 , 187 , 36 , 36 , 187 , 114 , 76 , 172 , 31 , 3 , 187 , 31 , 31 , 24 , 187 , 31 , 187 , 187 , 36 , 187 , 187 , 11 , 31 , 36 , 31 , 31 , 31 , 36 , 187 , 31 , 36 , 187 , 8 , 24 , 24 , 187 , 31 , 180 , 76 , 187 , 187 , 187 , 36 , 36 , 24 , 9 , 187 , 187 , 1 , 187 , 187 , 187 , 66 , 76 , 187 , 186 , 187 , 187 , 187 , 21 , 60 , 187 , 31 , 36 , 187 , 31 , 187 , 36 , 31 , 127 , 31 , 187 , 187 , 60 , 187 , 9 , 31 , 185 , 187 , 76 , 31 , 180 , 1 , 31 , 9 , 187 , 31 , 31 , 186 , 185 , 186 , 36 , 60 , 31 , 187 , 24 , 9 , 31 , 187 , 31 , 24 , 187 , 127 , 31 , 2 , 21 , 9 , 187 , 31 , 9 , 187 , 187 , 2 , 31 , 36 , 187 , 8 , 36 , 31 , 172 , 60 , 31 , 187 , 31 , 24 , 9 , 31 , 93 , 9 , 31 , 187 , 24 , 76 , 36 , 187 , 187 , 36 , 36 , 24 , 36 , 31];
    private static $randomizedCountries =[31,82,36,82,187,82,18,142,31,7,114,169,24,186,170,142,187,31,187,17,36,31,9,162,43,170,142,144,31,187,60,162,76,24,9,9,162,162,60,170,144,31,187,68,150,142,187,169,64,31,170,9,144,187,142,36,133,131,127,80,82,187,13,60,151,24,187,76,60,142,187,14,162,162,187,172,82,31,187,187,82,64,187,13,80,169,170,23,12,37,31,30,24,187,36,162,162,60,31,151,150,31,170,170,31,36,14,114,31,187,9,36,64,162,170,187,64,170,80,150,162,187,82,142,14,31,131,169,64,187,36,87,21,36,169,82,64,31,82,187,187,151,14,31,9,144,8,66,144,187,120,80,36,170,144,150,187,150,66,36,187,9,36,150,36,144,64,24,82,82,60,169,144,187,187,76,66,64,170,76,9,144,9,64,162,78,142,18,80,82,36,162,187,31,31,187,107,17,82,60,14,144,10,66,82,31,187,77,131,82,187,187,18,150,60,31,36,187,76,187,31,187,127,36,169,64,24,162,187,76,131,169,187,170,76,66,9,64,150,36,131,31,42,76,31,187,82,78,127,13,169,162,144,187,150,9,75,24,162,187,12,187,144,187,187,187,162,64,187,82,31,187,187,19,151,12,169,187,151,162,144,18,9,144,187,187,180,5,24,144,187,8,17,170,31,127,52,64,43,43,64,31,31,187,120,187,144,22,150,187,21,131,36,142,187,189,169,170,114,80,9,144,31,64,187,18,162,162,162,31,187,187,180,144,4,21,13,82,142,187,170,187,186,31,187,5,120,13,60,144,144,31,187,76,144,187,187,60,142,187,78,14,142,60,169,60,64,64,170,170,187,170,28,8,76,60,144,187,25,144,187,66,80,186,60,187,66,187,82,114,9,162,31,187,82,170,5,21,66,76,131,162,76,187,36,144,187,64,36,187,187,13,3,11,170,142,162,187,82,131,127,60,64,144,31,150,60,187,187,187,131,150,144,187,187,31,78,36,144,52,169,60,18,142,187,187,24,82,36,142,64,75,21,31,9,169,36,91,18,60,170,144,187,187,187,60,31,31,79,187,187,187,151,60,142,187,187,187,60,60,170,114,60,144,8,36,170,1,9,162,170,144,31,187,185,162,7,75,36,31,11,66,9,64,64,187,90,169,66,31,60,170,31,52,150,36,142,9,60,180,150,169,41,187,187,69,31,187,162,31,8,60,187,114,31,9,60,187,187,82,36,36,170,24,24,187,52,150,187,80,60,64,169,144,187,5,14,9,142,31,43,66,80,150,144,36,150,169,31,7,142,142,24,64,31,132,78,36,142,9,142,144,131,142,17,162,187,180,36,64,1,41,144,30,21,144,5,162,31,79,42,31,150,187,4,150,31,31,82,31,187,180,76,80,18,41,151,129,64,24,131,144,187,26,14,187,31,14,187,142,142,16,64,170,142,31,187,162,170,170,76,82,60,170,142,52,169,82,187,187,82,64,2,187,169,31,187,114,170,144,42,82,142,37,131,9,131,169,187,66,187,187,80,13,114,114,169,11,144,31,77,75,170,170,21,144,29,66,82,187,187,11,31,80,187,169,187,78,76,82,75,9,142,169,31,75,187,142,144,31,162,76,82,162,97,18,31,156,162,170,142,131,80,82,142,114,142,31,187,31,17,9,9,17,60,142,41,186,31,31,31,187,187,66,142,78,64,150,31,187,23,169,18,162,60,162,142,185,162,114,144,8,120,80,150,60,64,31,31,66,36,187,31,144,187,187,144,144,21,60,144,187,187,82,60,187,162,142,187,31,36,24,9,162,142,31,31,170,142,64,82,60,60,144,120,9,60,64,31,80,162,162,170,187,66,64,187,114,5,21,24,144,82,187,172,170,142,169,142,187,2,144,76,52,150,64,187,187,187,151,80,169,187,180,142,151,24,187,7,36,142,144,169,31,187,150,9,60,170,144,187,7,13,64,31,170,187,187,43,76,187,180,64,170,142,187,162,131,120,15,64,170,64,187,87,171,16,66,36,142,127,18,169,170,31,186,144,17,131,64,144,31,60,144,36,144,79,170,31,80,142,18,31,187,144,31,1,120,162,91,162,170,31,150,31,170,144,131,36,42,14,150,142,76,82,36,170,187,97,14,144,11,187,187,142,144,144,9,21,18,162,142,31,114,52,120,41,31,64,170,187,73,11,18,9,114,150,36,170,31,31,9,169,187,127,64,187,17,36,196,64,60,162,187,187,142,187,64,142,142,187,60,187,150,169,64,142,187,187,150,169,36,14,144,66,64,114,36,66,36,187,187,131,36,37,162,144,187,162,64,72,82,31,15,24,17,187,144,172,13,187,52,24,162,142,187,170,187,87,172,60,52,60,82,150,36,187,170,142,31,187,3,162,162,187,14,151,144,31,66,36,187,187,170,31,43,18,142,187,170,187,13,131,187,8,66,2,170,31,64,170,187,187,5,36,127,80,39,128,142,142,80,151,187,3,60,142,162,13,169,82,144,150,64,64,142,144,144,80,82,5,170,144,187,64,31,170,187,162,27,66,170,169,64,5,150,187,187,144,187,187,144,150,162,60,36,144,31,187,144,144,187,93,144,36,142,142,144,187,186,169,64,42,9,150,31,144,52,18,80,187,187,162,187,9,60,36,142,142,80,187,64,37,170,187,74,76,187,187,9,31,31,187,187,64,162,142,187,127,142,187,64,31,170,31,31,36,162,120,144,31];
    public static $countries=['','Afghanistan','Albania','Algeria','Andorra','Angola','Antigua & Deps','Argentina','Armenia','Australia','Austria','Azerbaijan','Bahamas','Bahrain','Bangladesh','Barbados','Belarus','Belgium','Belize','Benin','Bhutan','Bolivia','Bosnia Herzegovina','Botswana','Brazil','Brunei','Bulgaria','Burkina','Burundi','Cambodia','Cameroon','Canada','Cape Verde','Central African Rep','Chad','Chile','China','Colombia','Comoros','Congo','Congo {Democratic Rep}','Costa Rica','Croatia','Cuba','Cyprus','Czech Republic','Denmark','Djibouti','Dominica','Dominican Republic','East Timor','Ecuador','Egypt','El Salvador','Equatorial Guinea','Eritrea','Estonia','Ethiopia','Fiji','Finland','France','Gabon','Gambia','Georgia','Germany','Ghana','Greece','Grenada','Guatemala','Guinea','Guinea-Bissau','Guyana','Haiti','Honduras','Hungary','Iceland','India','Indonesia','Iran','Iraq','Ireland {Republic}','Israel','Italy','Ivory Coast','Jamaica','Japan','Jordan','Kazakhstan','Kenya','Kiribati','Korea North','Korea South','Kosovo','Kuwait','Kyrgyzstan','Laos','Latvia','Lebanon','Lesotho','Liberia','Libya','Liechtenstein','Lithuania','Luxembourg','Macedonia','Madagascar','Malawi','Malaysia','Maldives','Mali','Malta','Marshall Islands','Mauritania','Mauritius','Mexico','Micronesia','Moldova','Monaco','Mongolia','Montenegro','Morocco','Mozambique','Myanmar, {Burma}','Namibia','Nauru','Nepal','Netherlands','New Zealand','Nicaragua','Niger','Nigeria','Norway','Oman','Pakistan','Palau','Panama','Papua New Guinea','Paraguay','Peru','Philippines','Poland','Portugal','Qatar','Romania','Russian Federation','Rwanda','Saint Vincent & the Grenadines','Samoa','San Marino','Sao Tome & Principe','Saudi Arabia','Senegal','Serbia','Seychelles','Sierra Leone','Singapore','Slovakia','Slovenia','Solomon Islands','Somalia','South Africa','South Sudan','Spain','Sri Lanka','St Kitts & Nevis','St Lucia','Sudan','Suriname','Swaziland','Sweden','Switzerland','Syria','Taiwan','Tajikistan','Tanzania','Thailand','Togo','Tonga','Trinidad & Tobago','Tunisia','Turkey','Turkmenistan','Tuvalu','Uganda','Ukraine','United Arab Emirates','United Kingdom','United States','Uruguay','Uzbekistan','Vanuatu','Vatican City','Venezuela','Vietnam','Yemen','Zambia','Zimbabwe'];
    //public static $priceSimilarsStemed = ['price','free','amount','bill','cost','demand','discount','estim','expenditur','expens','fare','fee','figur','output','pai','payment','premium','rate','return','tariff','valuat','worth','apprais','assess','barter','bounti','ceil','charg','compens','consider','damag','disburs','due','exact','hire','outlai','prize','quotat','ransom','reckon','retail','reward','score','sticker','tab','ticket','toll','tune','wage','wholesal','apprais','asking pric','face valu','evalu','fix','mark down','mark up','put a price on','reduc','currenc','monei','capit','cash','check','fund','properti','salari','wage','wealth','banknot','bankrol','bread','buck','coin','coinag','financ','fund','gold','greenback','loot','resourc','rich','roll','silver','speci','treasur','almighty dollar','hard cash','legal tend','medium of exchang','excis','levi','tax','impost','price tag','budget','consumpt','debt','insur','invest','loan','loss','mortgag','oblig','payrol','spend','sum','bite','debit','decrement','depriv','forfeit','forfeitur','outdo','overhead','surcharg','upkeep','bottom lin','out of pocket','buck','note','refund','reserv','secur','stock','suppli','bullion','cabbag','dinero','dough','lot','pledg','princip','remuner','save','scratch','skin','wampum','wherewith','chicken fe','green stuff','legal tend','mazumah','ready asset','','conserv','preserv','repair','cost','expens','keep','run','subsist','support','susten','sustent','aid','alimoni','alloc','allot','annuiti','contribut','gift','grant','pension','quota','ration','scholarship','stipend','subsidi','apportion','bequest','commiss','cut','endow','fellowship','honorarium','inherit','interest','legaci','measur','part','piec','portion','quantiti','recompens','remitt','share','slice','stint','tast','credit'] ;//1375 character
    //public static $productSimilarsStemed = ['product','amount','brand','commod','crop','devic','fruit','merchandis','output','produc','product','profit','stock','work','aftermath','artifact','blend','brew','by-product','compound','concoct','confect','consequ','contriv','creation','decoct','effect','emolu','fabric','gain','handiwork','invent','issu','legaci','line','manufactur','offshoot','outcom','outgrowth','prepar','realiz','result','return','synthet','upshot','yield','spinoff','charact','qualiti','varieti','cast','class','descript','grade','make','sort','speci','aspect','condit','element','kind','natur','trait','affect','affirm','attribut','constitut','endow','essenc','factor','geniu','individu','mark','paramet','peculiar','predic','properti','savor','virtu','name of tun','nature of beast','attitud','facet','form','appear','bear','counten','demeanor','express','face','look','manner','mien','certif','assur','bail','bond','contract','coven','guarante','guaranti','pledg','secur','sureti','written promis','','care','freedom','insur','preserv','surveil','aegi','agreement','armament','armor','asylum','collater','compact','cover','custodi','defens','earnest','guard','immun','pact','pawn','precaut','redempt','refug','retreat','safeguard','safekeep','safe','salvat','sanctuari','shelter','shield','token','ward','warrant','safety measur','equiti','estat','farm','good','home','hous','land','ownership','plot','tract','wealth','worth','acreag','acr','asset','belong','build','capit','chattel','claim','dominion','effect','freehold','hold','inherit','mean','premis','proprietari','proprietorship','realti','resourc','rich','substanc','titl','possessorship','featur','lineament','look','','mug','physiognomi','puss','visag','bind','bundl','collect','gather','load','store','stow','batch','brace','bunch','burden','dispos','fasten','packag','tie','warehous','get readi','put in ord','account','assist','benefit','busi','duti','employ','mainten','offic','suppli','us','util','','advantag','applic','appropri','avail','check','courtesi','dispens','emploi','favor','fit','indulg','kind','labor','ministr','overhaul','relev','servic','servic','us','valu','circuit','life-cycl'];//1431 character

    public function isAboutProduct($entities){
        return count(array_intersect($entities,$this->productSimilars))>0;
    }
    function isAboutPrice($entities){
        return count(array_intersect($entities,$this->priceSimilars))>0;
    }

    function classifyTest(){
        echo "hello ,";
        $entities=  ['iPhone6','Giveaway','http://iphone7free4giveaway.com','Free','#iPhone'];
        $entities=$yourArray = array_map('strtolower', $entities);
        if($this->isAboutProduct($entities))
            echo "product,";

        if($this->isAboutPrice($entities))
            echo "price";
    }

    private static function entitiesToStrings($entities){
        $e=Array();
        foreach ($entities as $entity)
        array_push($e,$entity->name);
        return $e;
    }

    private static function calculateSentiment($post){
        $sentimentObject=$post->sentimetValue2;
        if( strcmp($sentimentObject->polarity,"negative")==0 ){
            return -$sentimentObject->polarity_confidence;
        }else
        if( strcmp($sentimentObject->polarity,"positive")==0 ){
            return $sentimentObject->polarity_confidence;
        }
        return ($sentimentObject->polarity_confidence - 0.5)*0.5;
    }

    static function isHaveShares($entities,$others){
        foreach ($entities as $entity){
            foreach ($others as $other){
                if(strcmp($entity,$other)==0){
                    return true;}
            }
        }
        return false;
    }

    static function sentimentToScale($sentiment){
        //1. very negative: [-1,-0.6[ ,2. [-0.6,-0.2[,3. [-0.2,0.2[,4. [0.2,0.6[,5. [0.6,1]
        if($sentiment<-0.2){
            if($sentiment<-0.6)
                return 1;
            return 2;
        }else{// $sentiment > -0.2
            if($sentiment<0.6){
                if($sentiment<0.2)
                    return 3;
                return 4;
            }
        }
        return 5;
    }

    static function classifyPosts($recordsToHandel=100){
        //23-7-2017
        //$posts=Post::all()->take($recordsToHandel)->where('analysed',1);//89521.72;96325.66 mSec is the execution time for 100 record ; 983106.87 mSec(=16 min) is the execution time for 1100 record out is 121 record ; 1489712.29 mSec for 1500 record out is 160
        //after adding indexs : 26086.91 mSec of 50 record, 30988.24 mSec for 100 record ; it's 0.3098824 for 1 record  60951*0.3098824 = 5.24 hours
        //
        //$posts=Post::all()->where('analysed',1);
        Post::where('analysed',1)->chunk(100, function ($posts) {
        //echo count($posts);
        //die();
        foreach ($posts as $post) {
            /*if($post->analysed!=1)
                continue;*/
                $entities=Classifier::entitiesToStrings($post->entitys2);
                $haveSharedPrice=self::isHaveShares($entities,Classifier::$priceSimilars);
                $haveSharedProduct=self::isHaveShares($entities,Classifier::$productSimilars);
                if($haveSharedPrice||$haveSharedProduct){
                    $analysis=new Analysis;
                    $analysis->post_id=$post->id;
                    $analysis->product_id=$post->product->id;
                    $analysis->productName=$post->product->name;
                    //$analysis->entities="";
                    $analysis->date=$post->date;
                    $datetime = new \DateTime($post->date);
                    $analysis->day=$datetime->format('d');
                    $analysis->month=$datetime->format('m');
                    $analysis->year=$datetime->format('Y');
                    if($post->customer_followers_count==0)
                        $analysis->cal_promotion=0;
                    else
                        $analysis->cal_promotion=($post->retweet_count+$post->likes_count)*100/$post->customer_followers_count;
                    $analysis->country=self::$randomizedCountries[rand(0,1200)];//$post->location;

                    $sentiment=Classifier::calculateSentiment($post);
                    $analysis->sentiment_scale=self::sentimentToScale($sentiment);
                    $analysis->sentiment=$sentiment;
                    if($haveSharedPrice){
                        $analysis->price=$sentiment;
                    }
                    if($haveSharedProduct){
                        $analysis->product=$sentiment;
                    }
                    $mining =new Mining;
                    $mining->setData($analysis);
                    $mining->setData($analysis);
                    $analysis->save();
                    $mining->save();
                    echo 'saved';
                }
                $post->analysed=2;
                $post->save();
               // echo ','.++self::$postsAnalysed;
            }
        } ) ;
    }

    public static function fixSentiment(){

        Mining::chunk(100, function ($records) {
            foreach ($records as $record) {
                if ($record->price === null)
                $record->sentiment = $record->product;
            else
                $record->sentiment = $record->price;
            $record->save();
        }
        } );
}

    public static function fixDate()
    {
         Mining::chunk(100, function ($records) {
            foreach ($records as $record) {
                $post = Post::find($record->post_id);
                $record->date = $post->date;
                $record->save();
            }
        });
    }
}