<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
       
            <!-- Ajout de table des posts de chaque utilisateur -->
            <div class="container mx-auto px-4 sm:px-8">
                <div class="py-8">
                    <div>
                        <h2 class="text-2xl font-semibold leading-tight">Mes posts</h2>
                    </div>
                    <div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-4 overflow-x-auto">
                        <div class="inline-block min-w-full shadow rounded-lg overflow-hidden">
                            <table class="min-w-full leading-normal">
                                <thead>
                                    <tr>
                                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Title</th>
                                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Body</th>
                                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach(auth()->user()->posts as $post)
                                    <tr>
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm w-2/5">{{$post->title}}</td>
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm w-2/5">{{$post->body}}</td>
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm w-2/5">
                                         <!-- Bouton pour modifier le post -->
                                            <a href="{{ route('post.edit', $post->slug)}}" class="border border-teal-500 bg-teal-500 text-white rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:bg-teal-600 focus:outline-none focus:shadow-outline">Modifier</a>
                                                <!-- On ajoute un formulaire pour la suppression pour y confirmer -->
                                                <form id = "{{ $post->id }}" action="{{ route('post.delete', $post->slug)}}" method="post">
                                                    <!-- Au niveau de chaque formulaire on ajoute le csrf -->
                                                    @csrf
                                                    <!-- La methode delete pour la supression à travers le formulaire -->
                                                    @method('DELETE')
                                                </form>
                                                <!-- boutton supprimer avec Pop-up de confirmation de suppression de post -->
                                                <button onclick="event.preventDefault();
                                                if(confirm('voulez-vous supprimer ce post'))
                                                document.getElementById( {{$post->id}}).submit();"                    
                                                class ="border border-yellow-500 bg-yellow-500 text-white rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:bg-yellow-600 focus:outline-none focus:shadow-outline" type="submit" >Supprimer</button></td>
                                    </tr>  
                                    @endforeach                  
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
            @if (Laravel\Fortify\Features::canUpdateProfileInformation())
                @livewire('profile.update-profile-information-form')

                <x-jet-section-border />
            @endif

            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                <div class="mt-10 sm:mt-0">
                    @livewire('profile.update-password-form')
                </div>

                <x-jet-section-border />
            @endif

            @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
                <div class="mt-10 sm:mt-0">
                    @livewire('profile.two-factor-authentication-form')
                </div>

                <x-jet-section-border />
            @endif

            <div class="mt-10 sm:mt-0">
                @livewire('profile.logout-other-browser-sessions-form')
            </div>

            

            @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
                <x-jet-section-border />

                <div class="mt-10 sm:mt-0">
                    @livewire('profile.delete-user-form')
                </div>
            @endif
        </div>
    </div>
<script src="https://cdn.tailwindcss.com"></script>
</x-app-layout>
