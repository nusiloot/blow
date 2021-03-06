@extends('layouts.layout')
@section('content')
<div style='z-index:100'>
  <input class="input-date" type="text" name="" placeholder="2020-01-01" id="datepicker">
  <button type="button" onclick="gotoDate()"> Y aller</button>
</div>

<div class="btn-wrapper">
  <button type="button" name="btn-success" data-toggle="modal" data-target="#modalCRoom" class="btn-success">AJOUTER SALLE</button>
  <button type="button" name="btn-success" data-toggle="modal" data-target="#modalUDRoom" class="btn-success">MODIFIER SALLE</button>
  <button type="button" name="btn-success" data-toggle="modal" data-target="#modalUDUser" class="btn-success">SUPPRIMER UTILISATEUR</button>
<div>

  <div class="container">
    <div class="ct" id="accueil">
    <div class="ct" id="calendrier">
          <div class="page" id="p1">
          <div class="container">
              @extends('components.modals.modalCRoom')
              @extends('components.modals.modalUDRoom')
              @extends('components.flash-message')
                <section><div id="calendar"></div></section>
          </div>
          </div>
          <div class="page" id="p2">
          <div class="container">
          </div>
          </div>
    </div>
    </div>
  </div>
@endsection
