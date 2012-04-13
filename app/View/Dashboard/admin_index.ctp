<div id="aide"><!-- début aide -->
	<div id="screen-meta" class="metabox">
		<div id="aide_wrap" style="display: none"> <!-- class="hidden" -->
			<div id="aide_back"></div>
			<div id="aide_colonnes">
				<div class="colonne_menu"> <!-- Menu / colonne 1-->
					<ul>
						<li id="tab-link-overview" class="active">
							<a href="#tab-panel-overview">Vue d&rsquo;ensemble</a>
						</li>
					
						<li id="tab-link-help-navigation">
							<a href="#tab-panel-help-navigation">Navigation</a>
						</li>
					
						<li id="tab-link-help-layout">
							<a href="#tab-panel-help-layout">Arrangement</a>
						</li>
					
						<li id="tab-link-help-content">
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
				
					<div id="tab-panel-help-navigation" class="help-tab-content">
						<p>
							La navigation située à gauche de l&rsquo;écran fournit tous les liens pour accéder à la console d&rsquo;administration, avec les sous-menus qui s&rsquo;affichant au survol. Vous pouvez réduire ce menu à ses seules icônes en cliquant sur la flèche de repliement située en bas du menu.
						</p>
						<p>
							Les liens contenus dans la barre d&rsquo;outils placée en haut de l&rsquo;écran relient votre tableau de bord à la partie publique de votre site, et fournissent un accès rapide à votre profil et de précieuses informations sur WordPress.
						</p>
					</div>
				
					<div id="tab-panel-help-layout" class="help-tab-content">
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
				
					<div id="tab-panel-help-content" class="help-tab-content">
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
    <?php echo $this->Html->image('icone-home.png',array('width'=>'62','height'=>'62')) ?>
    <?php echo $title_for_layout ?>
</h1>
<div id="dashboard">
    <div class="bloc_gauche">
        <div id="dashboard_aujourdhui" class="bloc">
            <div class="bloc_titre">
               <p>Aujourd'hui</p>
            </div>
            <div class="bloc_contenu">
				<div class="bloc_gauche">
                    <table>
                        <thead>
                            <tr>
                                <th colspan="2">Contenu</th>
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
                <div class="bloc_droit">
                    <table class="no_paire">
                        <thead>
                            <tr>
                                <th colspan="2"><em>Livre d'or</em></th>
                            </tr>
                        </thead>
                        <tbody>
	                         <tr>
	                             <td>
	                             		<h4><?php echo $totalComments ?></h4>
	                             </td>
	                             <td>
	                                 <?php $terminaison = ($totalComments > 1) ? 's' : '' ?>
	                                 Commentaire<?php echo $terminaison ?>
	                             </td>
	                         </tr>
	                         <tr>
	                             <td>
	                           		<h4><?php echo $totalApproved ?></h4>
	                           	</td>
	                             <td class="good">
	                                 <?php $terminaison = ($totalApproved > 1) ? 's' : '' ?>
	                                 Approuvé<?php echo $terminaison ?>
	                             </td>
	                         </tr>
	                         <tr>
	                             <td>
	                             		<h4><?php echo $totalWaiting ?></h4>
	                             	</td>
	                             <td class="neutral">En attente</td>
	                         </tr>
                        </tbody>
                    </table>
				</div>
			</div>	
        </div>
        <div id="dashboard_derniers_brouillons" class="bloc">
            <div class="bloc_titre">
               <p>Brouillons récents</p>
            </div>
            <div class="bloc_contenu">
                <?php if (!empty($last_drafts)): ?>
                    <ul id="derniers_brouillons">
                     <?php foreach ($last_drafts as $k => $v): ?>
                        <li class="item_brouillon">
                            <?php echo $this->Html->link($v['Post']['name'],array('action'=>'edit','controller'=>'posts',$v['Post']['id'])); ?>
                            <span class="date"><?php echo $this->date->format($v['Post']['created'],'FRS') ?></span>
                            <?php  echo $this->Text->truncate($v['Post']['content'],200,array('exact'=>false,'html'=>true));?>
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
        <div id="dashboard_derniers_commentaires" class="bloc">
            <div class="bloc_titre">
               <p>Commentaires récents</p>
            </div>
            <div class="bloc_contenu">
                <?php if (!empty($last_comments)): ?>
                	<div id="derniers_commentaires">
             			<?php foreach ($last_comments as $k => $v): ?>
								<?php $class = $v['Guestbook']['approved'] == 0  ? 'non_approuve' : ''?>
								<div class=" item_commentaire <?php echo $class ?>">
									<div class="item_commentaire_wrap">
										<h4 class="item_commentaire_meta"><cite class="item_commentaire_auteur"><?php echo $v['Guestbook']['author'] ?></cite>
										<?php echo (!empty($class)) ? '[en attente]' : '' ?></h4>
										<blockquote><p><?php echo $v['Guestbook']['content'] ?></p></blockquote>
										<?php echo $this->Html->link("Voir le commentaire",array('plugin'=>'guestbook','action'=>'index','controller'=>'guestbooks','admin'=>false,'#'=>$v['Guestbook']['id']),array('target'=>'_blank')); ?>
									</div>
								</div>
							<?php endforeach ?>
             	</div>
                <?php else: ?>
                    <p>Aucun commentaires</p>
                <?php endif ?>
            </div>
        </div>
    </div>
    <div class="bloc_droit">
        <div id="dashboard_aujourdhui" class="bloc">
            <div class="bloc_titre">
               <p>Mes catalogues</p>
            </div>
            <div class="bloc_contenu">
				<div class="bloc_gauche">
                    <table>
                        <thead>
                            <tr>
                                <th colspan="2">Robes de mariées</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><h4><?php echo $totalRobe ?></h4></td>
                                <td>
                                    <?php $terminaison = ($totalRobe > 1) ? 's' : '' ?>
                                    Robe<?php echo $terminaison ?>
                                </td>
                            </tr>
                            <tr>
                                <td><h4><?php echo $totalProduct_creator ?></h4></td>
                                <td>
                                    <?php $terminaison = ($totalProduct_creator > 1) ? 's' : '' ?>
                                    Créateur<?php echo $terminaison ?>
                                </td>
                            </tr>
                            <tr>
                                <td><h4><?php echo $totalProduct_taille ?></h4></td>
                                <?php $terminaison = ($totalProduct_taille > 1) ? 's' : '' ?>
                                <td>Taille<?php echo $terminaison ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="bloc_droit">
                    <table class="no_paire">
                        <thead>
                            <tr>
                                <th colspan="2"><em>Accessoires</em></th>
                            </tr>
                        </thead>
                        <tbody>
	                         <tr>
	                             <td>
	                             	<h4><?php echo $totalAccessoire ?></h4>
	                             </td>
	                             <td>
	                                 <?php $terminaison = ($totalAccessoire > 1) ? 's' : '' ?>
	                                 Accessoire<?php echo $terminaison ?>
	                             </td>
	                         </tr>
	                         <tr>
	                             <td>
	                           		<h4><?php echo $totalProduct_category ?></h4>
	                           	</td>
	                             <td>
	                                 <?php $terminaison = ($totalProduct_category > 1) ? 's' : '' ?>
	                                 Catégorie<?php echo $terminaison ?>
	                             </td>
	                         </tr>
                        </tbody>
                    </table>
				</div>
			</div>	
        </div>
        <div class="cb"></div>
    </div>
</div>