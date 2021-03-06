<?php
/**
 * Created by PhpStorm.
 * User: manue_001
 * Date: 20-08-15
 * Time: 13:42
 */

$note = getDBDocument($noteId);

?>
@extends('master')
@section('title', 'Note viewer')

@section('sidebar')

    @parent


@stop

@section('content')
    @include("note.menu", ["noteId", $noteId])
    <div id="note_viewer_container" onclick="updateNote();" style="padding: 20px; border: 3px groove #24a199">

    </div>
    <div id="signature">
        <?php
        echo $note->getAttribute('username');
        ?><?php
        echo $note->getAttribute('updated_at');
        ?>
    </div>
    <div id="lien_liste" style="padding: 20px; border: 3px groove #24a199">

    </div>
    <script type="application/javascript">
        function updateJoint() {
            $.get("{{asset("note/joint/list/$noteId") }}",
                    function (server_response) {
                        $("#lien_liste").html(server_response);
                    });
        }
        var type_html_start = "errors";
        var text_to_load = "";
        var type_viewed = "unknown";
        function updateNote() {

            $.get("{{asset("file/mime-type/$noteId")}}",

                    function (server_response) {
                        if (server_response.search("image") > -1) {
                            type_html_start = "<img src='{{ asset("file/view/".$noteId) }}''/>";
                        } else if (server_response.search("text") > -1) {
                            type_html_start = "{{ asset("file/view/".$noteId) }}";
                            type_viewed = "text";
                        } else if (server_response.search("directory") > -1) {
                            type_html_start = "Repertoire";
                        } else if (server_response.search("application/pdf") > -1) {
                            type_html_start = "<a href='{{asset("file/view/".$noteId)}}' target='_NEW'>Visualiser sur une nouvelle page</a><br/><iframe src ='{{asset("js/viewerJS")."/#".asset("file/view/$noteId")}}' width='400' height='300' allowfullscreen webkitallowfullscreen></iframe>";
                        }

                        $("#note_viewer_container").html(type_html_start);


                        if (type_viewed == "text") {
                            $("#note_viewer_container").html("Loading text ...");
                            $.get(type_html_start,
                                    function (server_response) {
                                        $("#note_viewer_container").html(server_response);
                                    });
                        }

                    });

        }

        updateNote();

    </script>
    <a href="{{asset("note/joint/list/$noteId")}}">Liens </a>
@stop
