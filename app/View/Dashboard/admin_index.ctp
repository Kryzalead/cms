<div id="aide"><!-- début aide -->
	<div id="screen-meta" class="metabox">
			<div id="aide_wrap"> <!-- class="hidden -->
				<div id="aide_back"></div>
				<div id="aide_colonnes">
					<div class="colonne_menu"> <!-- Menu / colonne 1-->
						<ul>
							<li id="tab-link-overview" class="active">
								<a href="#tab-panel-overview">Vue d&rsquo;ensemble</a>
							</li>
						
							<li id="tab-link-help-navigation" class="">
								<a href="#tab-panel-help-navigation">Navigation</a>
							</li>
						
							<li id="tab-link-help-layout" class="">
								<a href="#tab-panel-help-layout">Arrangement</a>
							</li>
						
							<li id="tab-link-help-content" class="">
								<a href="#tab-panel-help-content">Contenu</a>
							</li>
						</ul>
					</div>

					<div class="aide_image"> <!-- plus d'informations / colonne 3-->
						<?php echo $this->Html->image('aide.png',array('width'=>128,'height'=>128)); ?>
					</div>
					
					<div class="colonne_texte_wrap"> <!-- les textes / colonne centrale-->
						<div id="tab-panel-overview" class="active help-tab-content">
							<p>
								Bienvenu dans votre tableau de bord ! <br/> Ceci est l&rsquo;écran que vous verrez lorsque vous vous connectez à votre site, et qui vous donne accès à l&rsquo;ensemble des fonctionnalités de gestion de WordPress. Vous pouvez obtenir de l&rsquo;aide dans n&rsquo;importe quel écran en cliquant sur l&rsquo;onglet « Aide » présent en haut à droite de votre navigateur.
							</p>
						</div>
					
						<div id="tab-panel-help-navigation" class=" help-tab-content">
							<p>
								La navigation située à gauche de l&rsquo;écran fournit tous les liens pour accéder à la console d&rsquo;administration, avec les sous-menus qui s&rsquo;affichant au survol. Vous pouvez réduire ce menu à ses seules icônes en cliquant sur la flèche de repliement située en bas du menu.
							</p>
							<p>
								Les liens contenus dans la barre d&rsquo;outils placée en haut de l&rsquo;écran relient votre tableau de bord à la partie publique de votre site, et fournissent un accès rapide à votre profil et de précieuses informations sur WordPress.
							</p>
						</div>
					
						<div id="tab-panel-help-layout" class=" help-tab-content">
							<p>
								Vous pouvez utiliser les contrôles suivants pour organiser l&rsquo;écran du tableau de bord pour afin de se plier à votre manière de l&rsquo;utiliser. La plupart des écrans de la console d&rsquo;administration peuvent également être organisés de cette manière.
							</p>
							<p>
								<strong>Réglages d&rsquo;écran</strong> - Utiliser l&rsquo;onglet des réglages d&rsquo;écran pour choisir les modules du tableau de bord à afficher, et le nombre de colonnes afficher.</p>
							<p>
								<strong>Glisser/déposer</strong> - Pour réarranger les modules, glissez/déposez-les en cliquant sur la barre de titre du module sélectionné, et relâchez-la lorsque vous apercevez un rectangle avec une bordure grise à l&rsquo;emplacement où vous souhaitez placer le module.
							</p>
							<p>
								<strong>Contrôle des boîtes</strong> - Cliquer sur la barre de titre d&rsquo;une boîte pour l&rsquo;étendre ou la minimiser. Par ailleurs, certaines boîtes ont un contenu configurable, et afficheront un lien &laquo;&nbsp;Configurer&nbsp;&raquo; dans la barre de titre lorsque la souris la survolera.
							</p>
						</div>
					
						<div id="tab-panel-help-content" class=" help-tab-content">
							<p>
								Les modules de l&rsquo;écran du tableau de bord sont&nbsp;:
							</p>
							<p>
								<strong>Aujourd&rsquo;hui</strong> - Affiche un résumé du contenu de votre site, et indique le thème et la version de WordPress que vous utilisez.</p><p><strong>Commentaires récents</strong> - Affiche les commentaires les plus récents sur vos articles (configurable, jusqu&rsquo;à 30), et vous permet de les modérer directement.
							</p>
							<p>
								<strong>Liens entrants</strong> - Affiche les liens vers votre site, tels qu&rsquo;indiqués par Google Blog Search.
							</p>
							<p>
								<strong>Press-Minute</strong> - Crée un nouvel article rapidement, et de le publier directement ou de le garder comme brouillon.
							</p>
							<p>
								<strong>Brouillons récents</strong> - Affiche un lien vers les 5 derniers brouillons d&rsquo;articles que vous avez commencés.
							</p>
							<p>
								<strong>Blog de WordPress</strong> - Affiche les dernières nouvelles officielles du projet WordPress.
							</p>
							<p>
								<strong>Autres actualités de WordPress (en français)</strong> - Affiche le flux du <a href="http://www.wordpress-fr.net/planet/" target="_blank">Planet de WordPress</a>. Vous pouvez configurer ce module pour utiliser un autre flux de votre choix.
							</p>
							<p>
								<strong>Extensions</strong> - Affiche l&rsquo;extension la plus populaire, la plus récente et la plus récemment mise à jour, en provenance du dépôt d&rsquo;extensions de WordPress.org.
							</p>
						</div>
					</div>
				</div>
			</div>
				<div id="ecran_options_wrap" class="hidden">options</div> <!-- Options écran -->
		</div>

	<div id="screen-meta-links"><!-- bouton2-->
		<div id="contextual-help-link-wrap" class="hide-if-no-js screen-meta-toggle">
			<a href="#aide_wrap" id="contextual-help-link" class="show-settings">Aide</a>
		</div>

		<div id="bouton_options_ecran" class="hide-if-no-js screen-meta-toggle">
			<a href="#ecran_options_wrap" id="show-settings-link" class="show-settings">Options de l&rsquo;écran</a>
		</div>
	</div>
</div><!-- fin aide -->



<h1>
    <?php echo $this->Html->image('icone-home.png',array('width'=>'62px','height'=>'62px')) ?>
    <?php echo $title_for_layout ?>
</h1>
<div id="dashboard">
    <div class="left">
        <div id="dashboard-today" class="bloc">
            <div class="title">
                Aujourd'hui
            </div>
            <div class="content">
                <div class="left">
                    <table class="noalt">
                        <thead>
                            <tr>
                                <th colspan="2"><em>Contenu</em></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><h4><?php echo $totalPage ?></h4></td>
                                <td>
                                    <?php $terminaison = ($totalPage > 1) ? 's' : '' ?>
                                    Page<?php echo $terminaison ?>
                                </td>
                            </tr>
                            <tr>
                                <td><h4><?php echo $totalPost ?></h4></td>
                                <td>
                                    <?php $terminaison = ($totalPost > 1) ? 's' : '' ?>
                                    Article<?php echo $terminaison ?>
                                </td>
                            </tr>
                            <tr>
                                <td><h4><?php echo $totalCategory ?></h4></td>
                                <?php $terminaison = ($totalCategory > 1) ? 's' : '' ?>
                                <td>Catégorie<?php echo $terminaison ?></td>
                            </tr>
                            <tr>
                                <td><h4><?php echo $totalTag ?></h4></td>
                                <?php $terminaison = ($totalTag > 1) ? 's' : '' ?>
                                <td>Mot<?php echo $terminaison ?>-clefs</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="right">
                    <table class="noalt">
                        <thead>
                            <tr>
                                <th colspan="2"><em>Commentaires</em></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><h4>46 000</h4></td>
                                <td>Commentaires</td>
                            </tr>
                            <tr>
                                <td><h4>5</h4></td>
                                <td class="good">Approuvé</td>
                            </tr>
                            <tr>
                                <td><h4>0</h4></td>
                                <td class="neutral">En attente</td>
                            </tr>
                            <tr>
                                <td><h4>0</h4></td>
                                <td class="bad">Indésirable</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="cb"></div>
        <div id="dashboard-last-drafts" class="bloc">
            <div class="title">
                Brouillons récents
            </div>
            <div class="content">
                <?php if (!empty($last_drafts)): ?>
                    <ul id="lasts_draft" style="list-style-type: none">
                     <?php foreach ($last_drafts as $k => $v): ?>
                        <li class="draft_item">
                            <?php echo $this->Html->link($v['Post']['name'],array('action'=>'edit','controller'=>'posts',$v['Post']['id'])); ?>
                            <span><?php echo $this->date->format($v['Post']['created'],'FR') ?></span>
                            
                                <p><?php  echo $this->Text->truncate($v['Post']['content'],200,array('exact'=>false,'html'=>true));?></p>
                            
                        </li>
                    <?php endforeach ?>
                    </ul>
                <?php else: ?>
                    <div>
                        <p>Il  n'y a pas de brouillons actuellement</p>
                    </div>
                <?php endif ?>
            </div>
        </div>
    </div>
    <div class="right">
        <div id="last-comments" class="bloc">
            <div class="title">
                Commentaires récents
            </div>
            <div class="content">
                <table class="noalt">
                    <tbody>
                        <tr>
                            <td class="picture" style="width:80px;"><?php echo $this->Html->image('anonymous.png') ?></td>
                            <td>
                                <p>
                                    <strong><a href="#">John Doe</a></strong><br>
                                    <em>December 24, at 22:13 - <a href="#">Reply</a></em><br>
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam non nulla sapien, quis luctus felis. Fusce sodales tempus tincidunt. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam non nulla sapien, quis luctus felis. Fusce sodales tempus tincidunt.
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td class="picture" style="width:80px;"><?php echo $this->Html->image('anonymous.png') ?></td>
                            <td>
                                <p>
                                    <strong><a href="#">John Doe</a></strong><br>
                                    <em>December 24, at 22:13 - <a href="#">Reply</a></em><br>
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam non nulla sapien, quis luctus felis. Fusce sodales tempus tincidunt. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam non nulla sapien, quis luctus felis. Fusce sodales tempus tincidunt.
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td class="picture" style="width:80px;"><?php echo $this->Html->image('anonymous.png') ?></td>
                            <td>
                                <p>
                                    <strong><a href="#">John Doe</a></strong><br>
                                    <em>December 24, at 22:13 - <a href="#">Reply</a></em><br>
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam non nulla sapien, quis luctus felis. Fusce sodales tempus tincidunt. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam non nulla sapien, quis luctus felis. Fusce sodales tempus tincidunt.
                                </p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="cb"></div>
    </div>
</div>

