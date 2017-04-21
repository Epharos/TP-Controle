<!DOCTYPE HTML>

<html>
	<head>
		<title>Contrôle web dynamique</title>
		<meta charset="utf-8">
	</head>

	<style>
	h1
	{
		text-align : center;
	}

	.tright
	{
		text-align : right
	}

	table
	{
		width : 75%;
		margin : auto;
	}

	.b
	{
		font-weight : bold;
	}

	#lists
	{
		text-align : center;
	}

	#lists select
	{
		width : 50%;
	}
	</style>

	<script>
	var sent = false;

	function VerifMail()
	{
		var f = document.getElementById("mail");
		var at = f.value.split("@");

		if(at.length != 2)
		{
			window.alert("Le mail n'est pas conforme [1]");
			return false;
		}

		var dot = at[1].split(".");

		if(dot.length != 2)
		{
			window.alert("Le mail n'est pas conforme [2]");
			return false;
		}

		return true;
	}

	function Inserer()
	{
		var left = document.getElementById("before");
		var right = document.getElementById("after");

		var o = document.createElement("option");
		o.text = left.value;

		right.add(o);

		left.remove(left.selectedIndex);
	}

	function Envoi()
	{
		if(!sent)
		{
			if(VerifTexte() && VerifMail())
			{
				window.alert("Formulaire envoyé !");
				sent = true;
				document.getElementById("formulaire").submit();
			}
		}
		else
		{
			window.alert("Vous avez déjà envoyé votre formulaire. Il est en cours de traitement ...");
		}
	}

	function VerifTexte()
	{
		var prenom = document.getElementById("prenom").value;
		var nom = document.getElementById("nom").value;
		var mail = document.getElementById("mail").value;
		var age = document.getElementById("age").value;

		var error = '<span style="font-weight : bold; color : red;">Ce champ est obligatoire</span>';

		var f1 = prenom == '';
		var f2 = nom == '';
		var f3 = mail == '';
		var f4 = age == '';

		document.getElementById("vprenom").innerHTML = f1 ? error : '';
		document.getElementById("vnom").innerHTML = f2 ? error : '';
		document.getElementById("vmail").innerHTML = f3 ? error : '';
		document.getElementById("vage").innerHTML = f4 ? error : '';

		if(f1 || f2 || f3 || f4)
		{
			return false;
		}

		return true;
	}
	</script>

	<body>
		<?php
			if(isset($_POST['prenom']) && isset($_POST['nom']) && isset($_POST['age']) && isset($_POST['mail']))
			{
				$color = $_POST['sexe'] == "homme" ? "cyan" : "pink";

				echo '<h1>Bonjour <span style="color :' . $color . '">' . $_POST['prenom'] . ' ' . $_POST['nom'] . '</span></h1>';
				echo '<h6 style="text-align : center;">La couleur change selon votre sexe</h4>';

				echo '<p>Vous avez actuellement ' . $_POST['age'] . ' ans (selon vos dires en tout cas)</p>';
				echo '<p>On peut vous contacter sur votre mail à <a href="mailto:' . $_POST['mail'] . '">votre adresse mail</a> (en cliquant sur le lien ou en copiant l\'adresse suivante : ' . $_POST['mail'] . ')</p>';

				if(isset($_POST['module']))
				{
					echo '<h3>Liste de vos matières</h3>';

					foreach($_POST['module'] as $valeur)
					{
						echo '- ' . $valeur . '<br>';
					}
				}

				// La partie affichant les activités ne marche pas du au fait que les éléments de la liste ne sont pas sélectionnés. Pour pallier à ce problème il faut les sélectionner par le JS à l'envoi du formulaire.

				if(isset($_POST['activities'])) 
				{
					echo '<h3>Vous pratiquez une ou plusieurs activités</h3>';

					foreach($_POST['activities'] as $activity)
					{
						echo '- ' . $activity . '<br>';
					}
				}
			}
		?>

		<h1>Formulaire d'information Etudiant</h1>

		<a href="javascript:{}" onclick="VerifMail();">Yolo</a>

		<form action="index.php" method="POST" id="formulaire">
			<table>
				<tr>
					<td class="tright b">Prénom : </td>
					<td><input type="text" name="prenom" id="prenom"></td>
					<td colspan="2" id="vprenom"></td>
				</tr>

				<tr>
					<td class="tright b">Nom : </td>
					<td><input type="text" name="nom" id="nom"></td>
					<td colspan="2" id="vnom"></td>
				</tr>

				<tr>
					<td class="tright b">Adresse électronique : </td>
					<td><input type="text" name="mail" id="mail"></td>
					<td colspan="2" id="vmail"></td>
				</tr>

				<tr>
					<td class="tright b">Age : </td>
					<td><input type="number" name="age" value="18" min="0" id="age"></td>
					<td colspan="2" id="vage"></td>
				</tr>

				<tr>
					<td class="tright b">Sexe : </td>
					<td>Homme <input type="radio" name="sexe" value="homme" checked></td>
					<td>Femme <input type="radio" name="sexe" value="femme"></td>
				</tr>

				<tr>
					<td class="b">Modules Etudiés durant l'année :</td>
				</tr>

				<tr>
					<td class="b"><input type="checkbox" name="module[]" value="Conception Internet Partie 1"> Conception Internet Partie 1</td>
					<td class="b"><input type="checkbox" name="module[]" value="Conception Internet Partie 2"> Conception Internet Partie 2</td>
					<td class="b"><input type="checkbox" name="module[]" value="Programmation objet"> Programmation objet</td>
					<td class="b"><input type="checkbox" name="module[]" value="Architecture des ordinateurs"> Architecture des ordinateurs</td>
				</tr>

				<tr>
					<td class="b"><input type="checkbox" name="module[]" value="Langage C/C++"> Langage C/C++</td>
					<td class="b"><input type="checkbox" name="module[]" value="Algorithmique"> Algorithmique</td>
					<td class="b"><input type="checkbox" name="module[]" value="Anglais"> Anglais</td>
					<td class="b"><input type="checkbox" name="module[]" value="Systèmes d'exploitation"> Systèmes d'exploitation</td>
				</tr>

				<tr class="b" style="text-align : center;" >
					<td>Activités proposées</td>
					<td></td>
					<td>Activités retenues</td> 
				</tr>

				<tr id="lists">
					<td>
						<select size="6" id="before">
							<option>Jet-Ski</option>
							<option>Plongée</option>
							<option>Tir à l'arc</option>
							<option>Planche à voilà</option>
							<option>Autres</option>
						</select>
					</td>

					<td><input type="button" value=">>> Insérer >>>" onclick="Inserer();"></td>

					<td>
						<select size="6" id="after" name="activities[]">

						</select>
					</td>
				</tr>

				<tr>
					<td></td>
					<td><input type="button" value="Soumettre" onclick="Envoi();" ondblclick="Envoi();"></td> 
					<!-- A quoi sert la fonction Envoi en cas de plusieurs clics ? Elle fait un submit pour envoyer le formulaire au PHP donc il est impossible de faire plusieurs clics, quand la page a fini de se (re)charger c'est un nouveau formulaire ... -->
					<td><input type="reset"></td>
				</tr>
			</table>
		</form>
	</body>
</html>