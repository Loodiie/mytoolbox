<?php
template('header', array(
    'title' => 'Boite à outils • Accueil',
));

$messages = [];
// Send contact form to database
if (!empty($_POST)) {
    $submited_items = array(
        'name' => addslashes($_POST['name']),
        'email' => $_POST['email'],
        'subject' => addslashes($_POST['subject']),
        'message' => addslashes($_POST['message'])
    );

    $validated_items = validate($submited_items, array(
        'name' => array(
            'label' => 'Name',
            'required' => true,
            'sanitize' => 'string',
            'min' => 2,
            'regexp' => '/^[a-zA-Z0-9\s]+$/'
        ),
        'email' => array(
            'label' => 'Email',
            'required' => true,
            'sanitize' => 'email',
        ),
        'subject' => array(
            'label' => 'Subject',
            'required' => true,
            'sanitize' => 'string',
        ),
        'message' => array(
            'label' => 'Message',
            'required' => true,
            'sanitize' => 'string',
        )
    ));

    $result = check_validation($validated_items);

    if (!is_passed($result)) {
        $messages = $result;
    } else {
        if (insert('admin_messages', $result)) {
            $messages['success'][] = 'Message envoyé !'; // voir pour mettre un timer
            // en-têtes pour le mail
            $headers = "From: my.toolboxpro@gmail.com\r\n";
            $headers .= "Reply-To: my.toolboxpro@gmail.com\r\n";
            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

            // corps du mail
            $to = $_POST['email']; // adresse email de l'utilisateur fournie dans le formulaire de contact
            $subject = 'Confirmation de réception de votre message';
            $message = 'Bonjour ' . $_POST['name'] . ',<br><br>';
            $message .= 'Nous avons bien reçu votre message avec le sujet "' . $_POST['subject'] . '".<br><br>';
            $message .= 'Nous vous recontacterons dès que possible.<br><br>';
            $message .= 'Merci de nous avoir contacté !<br><br>';
            $message .= "L'équipe de My ToolBox";

            // envoi du mail
            mail($to, $subject, $message, $headers);
        }
    }
}
?>

<!-- ======= About Section ======= -->
<section id="homepage" class="homepage">
    <div class="container">
        <div class="section-title">
            <h2>La boite à outils </h2>
            <p>La boite à outils est un site accessible 24h/24 et 7j/7 qui vous permet de réaliser un bon nombre de calculs ou transformations nécessaires au quotidien.</p>

            <!--<p>Transformer 1/4 de litres en millilitres ou encore convertir des euros en dollars n'a jamais été aussi simple !</p>-->
        </div>

        <?php getAlert($messages); ?>

        <div class="row">
            <div class="col-lg-12 pt-4 pt-lg-0 content">
                <h3>Il vous manque une fonctionnalité ?</h3>
                <p class="fst-italic">
                    Écrivez-nous grâce au formulaire de contact et nous vous répondrons dans les plus brefs délais.
                </p>
                <form id="contact-form" name="contact-form" method="POST">
                    <!--Grid row-->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="md-form mb-0">
                                <label for="name" class=""></label>
                                <input type="text" id="name" name="name" class="form-control" placeholder="Votre nom">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="md-form mb-0">
                                <label for="email" class=""></label>
                                <input type="email" id="email" name="email" class="form-control"placeholder="Votre Email">
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="md-form mb-0">
                                <label for="subject" class=""></label>
                                <input type="text" id="subject" name="subject" class="form-control"placeholder="Objet">
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="md-form">
                                <label for="message"></label>
                                <textarea id="message" name="message" rows="5" class="form-control md-textarea"placeholder="Votre message"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                    J'accepte que mes données soient utilisées dans le cadre de demande de fonctionnalité
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="text-center text-md-start">
                                <button type="submit" class="btn  btn-block btn-primary">Envoyer</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
</section><!-- End Home Section -->


<?php template('footer');
