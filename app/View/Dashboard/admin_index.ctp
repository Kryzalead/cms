<h1>
    <?php echo $this->Html->image('icone-home.png',array('width'=>'62px','height'=>'62px')) ?>
    <?php echo $title_for_layout ?>
</h1>
<div class="bloc left">
    <div class="title">
        Aujourd'hui
    </div>
    <div class="content">
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
                            <td><h4><?php echo $totalPages ?></h4></td>
                            <td>Pages</td>
                        </tr>
                        <tr>
                            <td><h4><?php echo $totalPosts ?></h4></td>
                            <td>Articles</td>
                        </tr>
                        <tr>
                            <td><h4>5</h4></td>
                            <td>Catégories</td>
                        </tr>
                        <tr>
                            <td><h4>20 000</h4></td>
                            <td>Tags</td>
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
            <div class="cb"></div>
        </div>
    </div>
</div>
<div class="bloc right">
    <div class="title">
        Commentaires récents
    </div>
    <div class="content">
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
</div>
