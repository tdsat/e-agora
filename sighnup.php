<div class="top_prod_box_big"><img src='images/details_box_top.gif' class='top_prod_box_big' /></div>
<div class="center_prod_box_big"  > <div id="textleft">



<?php
if(!isset($_SESSION['idUsers'])){
	//Αρχικοποιούμε τις τιμές
    $failedSignUp = TRUE; //Επειδή όταν ανοίγει η σελίδα, δεν έχουμε προσπαθ΄ήσει να κάνουμε εγγραφή 
    $sighnupbutton=NULL; // Δεν έχουμε ακόμα πατήσει το κουμπί εγγραφής
    
    if (key_exists("username", $_POST)) $username = $_POST["username"];
    if (key_exists("password", $_POST)) $password = $_POST["password"];
    if (key_exists("email", $_POST)) $email = $_POST["email"];
    if (key_exists("fName", $_POST)) $fName = $_POST["fName"];
    if (key_exists("lName", $_POST)) $lName = $_POST["lName"];
    if (key_exists("address", $_POST)) $address= $_POST["address"];
    if (key_exists("pcode", $_POST)) $pcode = $_POST["pcode"];
    if (key_exists("city", $_POST)) $city= $_POST["city"];
    if (key_exists("country", $_POST)) $country= $_POST["country"];
    if (key_exists("phone", $_POST)) $phone = $_POST["phone"];
    if (key_exists("dobDay", $_POST)) $dob["day"]= $_POST["dobDay"];
    if (key_exists("dobMonth", $_POST)) $dob["month"] = $_POST["dobMonth"];
    if (key_exists("dobYear", $_POST)) $dob["year"]= $_POST["dobYear"];
    if (key_exists("sighnupbutton", $_POST)) $sighnupbutton= $_POST["sighnupbutton"];
    
    //Ελέγχουμε αν έχει πατήσει το κουμπί για εγγραφή
    if($sighnupbutton)
    {
		//Στο $successfullSignUp βάζουμε το αποτέλεσμα της εντολής. Αν Είναι 0, τότε έγινε επιτιχής εγγραφή
        $failedSignUp=user_create($username,$password,$email,$fName,$lName,$address,$pcode,$city,$country,$phone,$dob);
        if ($failedSignUp){
			//Αν δεν έγινε επιτυχής εγγραφή, τότε εμφανίζουμε τα μυνήματα λάθους
		    echo "<div class='error'>Τα παρακάτω προβλήματα παρουσιάστηκαν κατα την προσπάθια αποστολής της αίτησής σας</br>";
            foreach($failedSignUp as $error){
				if(isset($error)) echo "$error</br>";
			}
			echo "</div>";
		}
		
        else //Αλλιώς εμφανίζουμε μύνημα επιτυχούς εγγραφής		
			echo "<h1>Η εγγραφή ήταν επιτυχής</h1>";
    }
	
//Αν δεν έχει κάνει εγγραφή ή εγγραφή δεν ήταν επιτυχής, εμφανίζουμε την φόρμα
if($failedSignUp){ ?> 
	<h1> Εγγραφή νέου χρήστη</h1>
		<hr />
		<form method="POST" action="index.php?action=sighnup">
		   <h3> Δημιουργία eAgora user id και password...Αυτά τα πεδία είναι απαραίτητα</h3>
	<table>
		<tr>
			<td>Δημιουργία eAgora user ID</td>
			<td><input type="text" name="username"></input></td>
		</tr>
		<tr>
			<td>Δημιουργία του κωδικού σας</td>
			<td><input type="password" name="password"></input></td>
		</tr>
		<tr>
			<td>Διεύθυνση email</td>
			<td><input type="text" name="email"></input></td>
		</tr>
		<tr>
			<td></td>
			<td></td>
		</tr>
	</table>
			
	<h3>Πείτε μας για τον αυτό σας...!</h3>
	<table>
		<tr>
			<td>Όνομα</td>
			<td><input type="text" name="fName"></input></td>
		</tr>
		<tr>
			<td>Επίθετο</td>
			<td><input type="text" name="lName"></input></td>
		</tr>
		<tr>
			<td>Διεύθυνση</td>
			<td><input type="text" name="address"></input></td>
		</tr>
		<tr>
			<td>Ταχυδρομικός κώδικας</td>
			<td><input type="text" name="pcode"></input></td>
		</tr>
		<tr>
			<td>Πόλη</td>
			<td><input type="text" name="city"></input></td>
		</tr>
		<tr>
			<td>Χώρα</td>
			<td><select name="country" id="countryId" a="1"><option value="1">United States</option><option value="2">Canada</option><option value="3">United Kingdom</option><option value="4">Afghanistan</option><option value="5">Albania</option><option value="6">Algeria</option><option value="7">American Samoa</option><option value="8">Andorra</option><option value="9">Angola</option><option value="10">Anguilla</option><option value="11">Antigua and Barbuda</option><option value="12">Argentina</option><option value="13">Armenia</option><option value="14">Aruba</option><option value="15">Australia</option><option value="16">Austria</option><option value="17">Azerbaijan Republic</option><option value="18">Bahamas</option><option value="19">Bahrain</option><option value="20">Bangladesh</option><option value="21">Barbados</option><option value="22">Belarus</option><option value="23">Belgium</option><option value="24">Belize</option><option value="25">Benin</option><option value="26">Bermuda</option><option value="27">Bhutan</option><option value="28">Bolivia</option><option value="29">Bosnia and Herzegovina</option><option value="30">Botswana</option><option value="31">Brazil</option><option value="32">British Virgin Islands</option><option value="33">Brunei Darussalam</option><option value="34">Bulgaria</option><option value="35">Burkina Faso</option><option value="37">Burundi</option><option value="38">Cambodia</option><option value="39">Cameroon</option><option value="40">Cape Verde Islands</option><option value="41">Cayman Islands</option><option value="42">Central African Republic</option><option value="43">Chad</option><option value="44">Chile</option><option value="45">China</option><option value="46">Colombia</option><option value="47">Comoros</option><option value="48">Congo, Democratic Republic of the</option><option value="49">Congo, Republic of the</option><option value="50">Cook Islands</option><option value="51">Costa Rica</option><option value="52">Cote d Ivoire (Ivory Coast)</option><option value="53">Croatia, Republic of</option><option value="55">Cyprus</option><option value="56">Czech Republic</option><option value="57">Denmark</option><option value="58">Djibouti</option><option value="59">Dominica</option><option value="60">Dominican Republic</option><option value="61">Ecuador</option><option value="62">Egypt</option><option value="63">El Salvador</option><option value="64">Equatorial Guinea</option><option value="65">Eritrea</option><option value="66">Estonia</option><option value="67">Ethiopia</option><option value="68">Falkland Islands (Islas Malvinas)</option><option value="69">Fiji</option><option value="70">Finland</option><option value="71">France</option><option value="72">French Guiana</option><option value="73">French Polynesia</option><option value="74">Gabon Republic</option><option value="75">Gambia</option><option value="76">Georgia</option><option value="77">Germany</option><option value="78">Ghana</option><option value="79">Gibraltar</option><option value="80">Greece</option><option value="81">Greenland</option><option value="82">Grenada</option><option value="83">Guadeloupe</option><option value="84">Guam</option><option value="85">Guatemala</option><option value="86">Guernsey</option><option value="87">Guinea</option><option value="88">Guinea-Bissau</option><option value="89">Guyana</option><option value="90">Haiti</option><option value="91">Honduras</option><option value="92">Hong Kong</option><option value="93">Hungary</option><option value="94">Iceland</option><option value="95">India</option><option value="96">Indonesia</option><option value="99">Ireland</option><option value="100">Israel</option><option value="101">Italy</option><option value="102">Jamaica</option><option value="103">Jan Mayen</option><option value="104">Japan</option><option value="105">Jersey</option><option value="106">Jordan</option><option value="107">Kazakhstan</option><option value="108">Kenya</option><option value="109">Kiribati</option><option value="111">Korea, South</option><option value="112">Kuwait</option><option value="113">Kyrgyzstan</option><option value="114">Laos</option><option value="115">Latvia</option><option value="116">Lebanon</option><option value="120">Liechtenstein</option><option value="121">Lithuania</option><option value="122">Luxembourg</option><option value="123">Macau</option><option value="124">Macedonia</option><option value="125">Madagascar</option><option value="126">Malawi</option><option value="127">Malaysia</option><option value="128">Maldives</option><option value="129">Mali</option><option value="130">Malta</option><option value="131">Marshall Islands</option><option value="132">Martinique</option><option value="133">Mauritania</option><option value="134">Mauritius</option><option value="135">Mayotte</option><option value="136">Mexico</option><option value="226">Micronesia</option><option value="137">Moldova</option><option value="138">Monaco</option><option value="139">Mongolia</option><option value="228">Montenegro</option><option value="140">Montserrat</option><option value="141">Morocco</option><option value="142">Mozambique</option><option value="143">Namibia</option><option value="144">Nauru</option><option value="145">Nepal</option><option value="146">Netherlands</option><option value="147">Netherlands Antilles</option><option value="148">New Caledonia</option><option value="149">New Zealand</option><option value="150">Nicaragua</option><option value="151">Niger</option><option value="152">Nigeria</option><option value="153">Niue</option><option value="154">Norway</option><option value="155">Oman</option><option value="156">Pakistan</option><option value="157">Palau</option><option value="158">Panama</option><option value="159">Papua New Guinea</option><option value="160">Paraguay</option><option value="161">Peru</option><option value="162">Philippines</option><option value="163">Poland</option><option value="164">Portugal</option><option value="165">Puerto Rico</option><option value="166">Qatar</option><option value="167">Romania</option><option value="168">Russian Federation</option><option value="169">Rwanda</option><option value="170">Saint Helena</option><option value="171">Saint Kitts-Nevis</option><option value="172">Saint Lucia</option><option value="173">Saint Pierre and Miquelon</option><option value="174">Saint Vincent and the Grenadines</option><option value="175">San Marino</option><option value="176">Saudi Arabia</option><option value="177">Senegal</option><option value="229">Serbia</option><option value="178">Seychelles</option><option value="179">Sierra Leone</option><option value="180">Singapore</option><option value="181">Slovakia</option><option value="182">Slovenia</option><option value="183">Solomon Islands</option><option value="184">Somalia</option><option value="185">South Africa</option><option value="186">Spain</option><option value="187">Sri Lanka</option><option value="189">Suriname</option><option value="190">Svalbard</option><option value="191">Swaziland</option><option value="192">Sweden</option><option value="193">Switzerland</option><option value="195">Tahiti</option><option value="196">Taiwan</option><option value="197">Tajikistan</option><option value="198">Tanzania</option><option value="199">Thailand</option><option value="200">Togo</option><option value="201">Tonga</option><option value="202">Trinidad and Tobago</option><option value="203">Tunisia</option><option value="204">Turkey</option><option value="205">Turkmenistan</option><option value="206">Turks and Caicos Islands</option><option value="207">Tuvalu</option><option value="208">Uganda</option><option value="209">Ukraine</option><option value="210">United Arab Emirates</option><option value="211">Uruguay</option><option value="212">Uzbekistan</option><option value="213">Vanuatu</option><option value="214">Vatican City State</option><option value="215">Venezuela</option><option value="216">Vietnam</option><option value="217">Virgin Islands (U.S.)</option><option value="218">Wallis and Futuna</option><option value="219">Western Sahara</option><option value="220">Western Samoa</option><option value="221">Yemen</option><option value="223">Zambia</option><option value="224">Zimbabwe</option></select></td>
		</tr>

		<tr>
			<td>Τηλέφωνο</td>
			<td><input type="text" name="phone"></input></td>
		</tr>
		<tr>
			<td>Ημερομηνίας γέννησης</td>
			<td>
			<select name="dobDay"> 
			 <?php for ($i=1 ; $i<=30;++$i) echo "<option value=$i>$i</option>";  ?>
			</select>
			<select name="dobMonth">
				<option value=1>Ιανουάριος</option>
				<option value=2>Φεβρουάριος</option>
				<option value=3>Μάρτιος</option>
				<option value=4>Απρίλιος</option>
				<option value=5>Μάιος</option>
				<option value=6>Ιούνιος</option>
				<option value=7>Ιούλιος</option>
				<option value=8>Αύγουστος</option>
				<option value=9>Σεπτέμβριος</option>
				<option value=10>Οκτώμβριος</option>
				<option value=11>Νοέμβριος</option>
				<option value=12>Δεκέμβριος</option>
			</select>
			<select name="dobYear">
				<?php 
				$timestamp=  getdate();
				$currentyear=$timestamp["year"];
				for($i=($currentyear-10); $i>1900; --$i) echo "<option value=$i>$i</option>"; 
				?>
			</select>
			</td>
			</tr>
	</table>
	<br/>
	<br />
	Πατώντας εγγραφή συμφωνώ οτι :

		<ul>
		<li>Έχω διαβάσει και συμφωνώ με τους όρους χρήσης</li>
		<li>Είμαι τουλάχιστον 18 χρονών</li>
		</ul>

			<input type="submit" name="sighnupbutton" value="Εγγραφή"/>
	</form>
<?php }
}
else echo "<h2>Είστε ήδη εγγεγραμένος<h2>"
?>

</div>
</div>
<div class="bottom_prod_box_big"><img src='images/details_box_bottom.gif' class='bottom_prod_box_big' /></div> 		

