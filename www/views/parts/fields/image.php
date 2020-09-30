<?php /** @var string $name */ ?>

<!-- Initialize the editor. -->
<script>
    var editor = new FroalaEditor('#<?= $name ?? 'content' ?>', {
        language: 'fr',
        quickInsertEnabled: false,
        placeholderText: 'Votre image ici',
        toolbarButtons: ['insertImage'],

        // Image
        imageUploadURL: '<?= url('medias.upload') ?>',
        imageAllowedTypes: ['webp', 'jpeg', 'jpg', 'png'],
        imageManagerLoadURL: '<?= url('medias.list') ?>',
        imageManagerDeleteURL: '<?= url('medias.delete') ?>',

        // Video
        videoUploadURL: '<?= url('medias.upload') ?>',
        videoAllowedTypes: ['webm', 'jpg', 'ogg', 'mp4'],

        events: {
            'image.removed': function ($img) {
                // Uncomment to enable automatic deletion
                /* fetch('<?= url('medias.delete') ?>', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({src: $img.attr('src')})
                }); */
            },
            'image.error': function (error, response) {
                console.error(error, response)
            }
        }
    });
</script>
