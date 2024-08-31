'use strict';
$(document).ready(function () {
    $('.sweet-basic').on('click', function () {
        swal('Hello world!');
    });
    $('.sweet-success').on('click', function () {
        swal("Good job!", "You clicked the button!", "success");
    });
    $('.sweet-warning').on('click', function () {
        swal("Good job!", "You clicked the button!", "warning");
    });
    $('.sweet-error').on('click', function () {
        swal("Good job!", "You clicked the button!", "error");
    });
    $('.sweet-info').on('click', function () {
        swal("Good job!", "You clicked the button!", "info");
    });

    $('.sweet-multiple').on('click', function () {
        swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this imaginary file!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete) {
                    swal("Poof! Your imaginary file has been deleted!", {
                        icon: "success",
                    });
                } else {
                    swal("Your imaginary file is safe!", {
                        icon: "error",
                    });
                }
            });
    });
    $('.sweet-prompt').on('click', function () {
        swal("Write something here:", {
            content: "input",
        })
            .then((value) => {
                swal(`You typed: ${value}`);
            });
    });
    $('.sweet-ajax').on('click', function () {
        swal({
            text: 'Search for a movie. e.g. "La La Land".',
            content: "input",
            button: {
                text: "Search!",
                closeModal: false,
            },
        })
            .then(name => {
                if (!name) throw null;
                return fetch(`https://itunes.apple.com/search?term=${name}&entity=movie`);
            })
            .then(results => {
                return results.json();
            })
            .then(json => {
                const movie = json.results[0];
                if (!movie) {
                    return swal("No movie was found!");
                }
                const name = movie.trackName;
                const imageURL = movie.artworkUrl100;
                swal({
                    title: "Top result:",
                    text: name,
                    icon: imageURL,
                });
            })
            .catch(err => {
                if (err) {
                    swal("Oh noes!", "The AJAX request failed!", "error");
                } else {
                    swal.stopLoading();
                    swal.close();
                }
            });
    });
});