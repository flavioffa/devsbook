<?=$render('header', ['loggedUser'=>$loggedUser]);?>

<section class="container main">
    <?=$render('sidebar', ['activeMenu'=>'config']);?>
    <section class="feed mt-10">

        <div class="row">
            <div class="column pr-5">

                <h1>Configurações</h1>
                <form method="POST" action="<?=$base;?>/config">
                    <?php if(!empty($flash)): ?>
                        <div class='flash'><?php echo $flash; ?></div>
                    <?php endif; ?>
                    </br>

                    <input type="hidden" name="email" value="<?=$user->email;?>" />

                    <label>Novo Avatar:
                    </br>
                        <input class="input" type="file" name="avatar" />
                    </label>
                    </br>
                    </br>
                    <label>Nova Capa:</br>
                        <input class="input" type="file" name="cover" />
                    </label>
                    </br>
                    </br>
                    <hr/>
                    </br>
                    <label>Nome Completo:</br>
                        <input class="input" type="text" name="name" value="<?=$user->name;?>"/>
                    </label>
                    </br>
                    </br>
                    <label>Data de Nascimento:</br>
                        <input class="input" type="text" name="birthdate" id="birthdate" value="<?=date('d/m/Y', strtotime($user->birthdate));?>"/>
                    </label>
                    </br>
                    </br>
                    <label>E-mail:</br>
                        <input placeholder="Digite seu e-mail" class="input" type="email" name="new-email" value="<?=$user->email;?>"/>
                    </label>
                    </br>
                    </br>
                    <label>Cidade:</br>
                        <input class="input" type="text" name="city" value="<?=$user->city;?>"/>
                    </label>
                    </br>
                    </br>
                    <label>trabalho:</br>
                        <input class="input" type="text" name="work" value="<?=$user->work;?>"/>
                    </label>
                    </br>
                    </br>
                    <hr/>
                    </br>
                    <label>Nova Senha:</br>
                        <input class="input" type="password" name="password" />
                    </label>
                    </br>
                    </br>
                    <label>Confirmar Nova Senha:</br>
                        <input class="input" type="password" name="password2" />
                    </label>
                    </br>
                    </br>
                    <input class="button" type="submit" value="Salvar" />

                </form>
            </div>
            <div class="column side pl-5">
                <?=$render('right-side');?>
            </div>
        </div>

    </section>
    <script src="https://unpkg.com/imask"></script>
<script>
IMask(
    document.getElementById('birthdate'),
    {
        mask:'00/00/0000'
    }
);
</script>
</section>
<?=$render('footer');?>