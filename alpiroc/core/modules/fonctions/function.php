<?php

//Fonction qui calcul la hauteur optimal du logos pour la template Alpiroc
function pdf_getHeightForLogoAlpiroc($logo, $url = false)
	{
		global $conf;
		$height=(empty($conf->global->MAIN_DOCUMENTS_LOGO_HEIGHT)?30:$conf->global->MAIN_DOCUMENTS_LOGO_HEIGHT);
		$maxwidth=80;
		include_once DOL_DOCUMENT_ROOT.'/core/lib/images.lib.php';
		$tmp=dol_getImageSize($logo, $url);
		if ($tmp['height'])
		{
			$width=round($height*$tmp['width']/$tmp['height']);
			if ($width > $maxwidth) {
				$height=$height*$maxwidth/$width;		
			}
		}
		//print $tmp['width'].' '.$tmp['height'].' '.$width; exit;
		return $height;
	}


/**
 * Returns the name of the thirdparty
 *
 * @param Societe|Contact $thirdparty Contact or thirdparty
 * @param Translate $outputlangs Output language
 * @return string
 */
function pdfBuildThirdpartyNameAlpiroc($thirdparty, Translate $outputlangs)
{
	//Recipient name
	$socname = '';

	// On peut utiliser le nom de la societe du contact
	if ($thirdparty instanceof Societe) {
		$socname .= $thirdparty->name;
		if (isset($thirdparty->name_alias)){//Test si la propriete existe pour rétro compatimbilité avec les version de dolibarr
			if (!empty($thirdparty->name_alias)) {
				$socname = $thirdparty->name_alias."\n";
			}
		}
	} elseif ($thirdparty instanceof Contact) {
		$socname = $thirdparty->socname;
	} else {
		throw new InvalidArgumentException();
	}

	return $outputlangs->convToOutputCharset($socname);
}
