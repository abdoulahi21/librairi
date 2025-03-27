
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Page ajout Categories
        </h2>
    </x-slot>
      <div class="container mt-5 col-md-5">
          <div class="card">
              <div class=""></div>
              <div class="card-body">
                  <form method="POST" action="{{route('categories.store')}}">
                      @csrf

                      <div class="mb-3">
                          <label for="formGroupExampleInput" class="form-label">Libelle</label>
                          <input type="text" name="libelle" class="form-control" id="formGroupExampleInput" placeholder="Libelle">
                      </div>
                      <button type="submit" class="btn btn-outline-success">Enregistrer</button>
                  </form>
              </div>
          </div>

      </div>
</x-app-layout>

