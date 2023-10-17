<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectUpsertRequest;
use App\Models\Type;
use App\Models\Project;
use App\Models\Technology;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\Uid\Uuid;


class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::all();

        return view('admin.projects.index', compact('projects'));
    }

    // SHOW FUNCTION

    public function show($slug)
    {
        $project = Project::where('slug', $slug)->first();

        return view('admin.projects.show', compact('project'));
    }

    // CREATE FUNCTION

    public function create() {

        $types = Type::all();
        $technologies = Technology::all();

        return view("admin.projects.create", compact("types", "technologies"));
    }

    // STORE FUNCTION CON FUNZIONE SLUG

    public function store(ProjectUpsertRequest $request)
    {
        $data = $request->validated(); // questa funzione ritorna i dati già validati da Laravel
        
        // qui invoco la funzione generateSlug tramite il $this e gli passo il titolo dell'articolo per ppoter generare lo slug        
        $data["slug"] = $this->generateSlug($data['title']);

        // $project = new Project();
        // $project->fill($data);
        // $project->save()

        // identifico il percorso della cartella in cui la rotta andrà a salvare l'immagine
        $data['image'] = Storage::put('projects', $data['image']);
        $data['user_id'] = Auth::id();

        // semplifico il procedimento usando il Project::create invece di newProject(), fill() e save() eseguendoli in un unico comando
        $project = Project::create($data);

        // genero l'attach dopo il create perché per funzionare ha bisogno dell'id del progetto.
        // uso allo stesso tempo `key_exist e `ìsset`, questa condizione verificherà che la chiave esista nell'array
        // e che sia impostata su un valore diverso da `null`.
        if (key_exists('technologies', $data) && isset($data['technologies'])) {
            $project->technologies()->attach($data["technologies"]);
        }

        return redirect()->route('admin.projects.show', $project->slug); //->with('success', 'Project created succeffully.')
    }

    // EDIT FUNCTION

    public function edit($slug)
    { // la funzione edit recupera il progetto corrente, richiesto con lo slug e lo passa con la variabile 'project' alla view .edit
        $project = Project::where('slug', $slug)->firstOrFail();
        $types = Type::all();
        $technologies = Technology::all();

        return view('admin.projects.edit', compact('project', 'types', 'technologies'));
    }

    // UPDATE FUNCTION

    public function update(ProjectUpsertRequest $request, $slug)
    {
        $data = $request->validated();

        $project = Project::where("slug", $slug)->firstOrFail();

        // se il titolo è cambiato, rigenero lo slug
        if ($data['title'] !== $project->title) {
            $data["slug"] = $this->generateSlug($data['title']);
        }

        // $project->update($data); // la funzione update aggiorna i dati e modifica il db

        // se spunto la checkbox, il server riceve il valore true
        // se non la spunto, il server riceve il valore false
        if (isset($data["is_published"])) {
            $project->is_published = true;
            $project->published_at = now();
        } else {
            $project->is_published = false;
            $project->published_at = null;
        }

        if (isset($data['image'])) {
            // questa funzione cancella l'immagine vecchia dalla cartella storage
            if ($project->image) {
                Storage::delete($project->image);
            }
            // identifico il percorso della cartella in cui la rotta andrà a salvare l'immagine
            $image_path = Storage::put('projects', $data['image']);

            $data['image'] = $image_path;
        }

        // assegnazione tecnologie
        // il metodo attach creerà una relazione tra il singolo progetto
        // e la lista delle tecnologie associate
        $project->technologies()->sync($data['technologies']);

        $project->update($data);

        return redirect()->route('admin.projects.show', $project->slug);
    }

    // DELETE FUNCTION

    public function destroy($slug)
    {
        // se un utente prova a cancellare un progetto ma non è loggato con l'email del gestore si ritorna err 403
        if (Auth::user()->email !== "cudini.andrea@gmail.com") {
            return abort(403);
        }

        $project = Project::where("slug", $slug)->firstOrFail();

        // se il progetto contiene un immagine, cancellando il progetto l'immagine rimane nel limbo
        if ($project->image) {
            Storage::delete($project->image);
        }

        $project->technologies()->detach();
        $project->delete();

        return redirect()->route("admin.projects.index");
    }

    // GENERATE SLUG FUNCTION    

    protected function generateSlug($title)
    {
        // contatore da usare per avere un numero incrementale
        $counter = 0;

        do {
            // creo uno slug e se il counter è maggiore di 0, concateno il counter
            $slug = Str::slug($title) . ($counter > 0 ? "-" . $counter : "");

            // cerco se esiste già un elemento con questo slug
            $alreadyExists = Project::where("slug", $slug)->first();

            $counter++;
        } while ($alreadyExists); // finché esiste già un elemento con questo slug, ripeto il ciclo per creare uno slug nuovo

        return $slug;
    }
}
