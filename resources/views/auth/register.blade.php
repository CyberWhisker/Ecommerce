<style>
    #fadeIn {
        opacity: 0;
        transition: opacity 0.5s;
        display: none;
    }
    #fadeOut {
        opacity: 1;
        transition: opacity 0.5s;
        display: block;
    }
    #fadeInBtn {
        opacity: 0;
        transition: opacity 0.5s;
        display: none;
    }
    #fadeOutBtn {
        opacity: 1;
        transition: opacity 0.5s;
        display: block;
    }
</style>

<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div id="fadeOut">
            <!-- First Name -->
            <div>
                <x-input-label for="first_name" :value="__('First Name')" />
                <x-text-input id="first_name" class="block mt-1 w-full" type="text" name="first_name" :value="old('first_name')" required autofocus autocomplete="first_name" />
                <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
                <span id="error_first_name" style="color:red"></span>
            </div>
            <!-- Middle Name -->
            <div>
                <x-input-label for="middle_name" :value="__('Middle Name')" />
                <x-text-input id="middle_name" class="block mt-1 w-full" type="text" name="middle_name" :value="old('middle_name')" required autofocus autocomplete="middle_name" />
                <x-input-error :messages="$errors->get('middle_name')" class="mt-2" />
                <span id="error_middle_name" style="color:red"></span>
            </div>
            <!-- Last Name -->
            <div>
                <x-input-label for="last_name" :value="__('Last Name')" />
                <x-text-input id="last_name" class="block mt-1 w-full" type="text" name="last_name" :value="old('last_name')" required autofocus autocomplete="last_name" />
                <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
                <span id="error_last_name" style="color:red"></span>
            </div>
            <!-- Address -->
            <div>
                <x-input-label for="address" :value="__('Address')" />
                <x-text-input id="address" class="block mt-1 w-full" type="text" name="address" :value="old('address')" required autofocus autocomplete="address" />
                <x-input-error :messages="$errors->get('address')" class="mt-2" />
                <span id="error_address" style="color:red"></span>
            </div>
            <!-- Contact Number -->
            <div>
                <x-input-label for="phone_number" :value="__('Contact Number')" />
                <x-text-input id="phone_number" class="block mt-1 w-full" type="text" name="phone_number" :value="old('phone_number')" required autofocus autocomplete="phone_number" />
                <x-input-error :messages="$errors->get('phone_number')" class="mt-2" />
                <span id="error_phone_number" style="color:red"></span>
            </div>
        </div>
        
        <div id="fadeIn">
            <!-- Email Address -->
            <div class="mt-4">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>
    
            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" />
    
                <x-text-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="new-password" />
    
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>
    
            <!-- Confirm Password -->
            <div class="mt-4">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
    
                <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation" required autocomplete="new-password" />
    
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>
            <div id="fadeOutBtn">
                <x-secondary-button class="ml-4" id="nextBtn">
                    {{ __('Next') }}
                </x-secondary-button>
            </div>
            <div id="fadeInBtn">
                <x-secondary-button class="ml-4" id="backBtn">
                    {{ __('Back') }}
                </x-secondary-button>
                <x-primary-button class="ml-4">
                    {{ __('Register') }}
                </x-primary-button>
            </div>
        </div>
    </form>
</x-guest-layout>

<script>
    document.getElementById('nextBtn').addEventListener("click", function() {
        var phoneNumberRegex = /^\d{11}$/;
        var numberPattern = /^[0-9]+$/;
        document.getElementById('error_first_name').innerHTML = '';
        document.getElementById('error_last_name').innerHTML = '';
        document.getElementById('error_middle_name').innerHTML = '';
        document.getElementById('error_phone_number').innerHTML = '';
        document.getElementById('error_address').innerHTML = '';
        var first_name = document.getElementById('first_name').value;
        var middle_name = document.getElementById('middle_name').value;
        var last_name = document.getElementById('last_name').value;
        var address = document.getElementById('address').value;
        var phone_number = document.getElementById('phone_number').value;
        if (first_name == '') {
            document.getElementById('error_first_name').append('First name required');
        } else if(middle_name == '') {
            document.getElementById('error_middle_name').append('Middle name required');
        } else if(last_name == '') {
            document.getElementById('error_last_name').append('Last name required');
        } else if(address == '') {
            document.getElementById('error_address').append('Address required');
        } else if(phone_number == '') {
            document.getElementById('error_phone_number').append('Middle name required');
        } else if(!numberPattern.test(phone_number)) {
            document.getElementById('error_phone_number').append('Please enter numbers only');
        } else if(!phoneNumberRegex.test(phone_number)) {
            document.getElementById('error_phone_number').append('Required 11 digit number');
        } else {
            var fadeInBtn = document.getElementById("fadeInBtn"); 
            var fadeOutBtn = document.getElementById("fadeOutBtn");
            var fadeIn = document.getElementById("fadeIn");
            var fadeOut = document.getElementById("fadeOut");
            fadeOutBtn.style.opacity = 0  
            fadeOut.style.opacity = 0    
            // Wait for the fade-out transition to complete before hiding it
            setTimeout(function() {
                fadeOutBtn.style.display = "none";
                fadeOut.style.display = "none";
                fadeInBtn.style.display = "block";
                fadeIn.style.display = "block";
    
                // Trigger the pop-in by changing its opacity
                fadeInBtn.style.opacity = 1;
                fadeIn.style.opacity = 1;
            }, 500);
        }
    });
    document.getElementById('backBtn').addEventListener("click", function() {
        var fadeInBtn = document.getElementById("fadeInBtn"); 
        var fadeOutBtn = document.getElementById("fadeOutBtn");
        var fadeIn = document.getElementById("fadeIn");
        var fadeOut = document.getElementById("fadeOut");
        fadeInBtn.style.opacity = 0  
        fadeIn.style.opacity = 0    
        // Wait for the fade-out transition to complete before hiding it
        setTimeout(function() {
            fadeOutBtn.style.display = "block";
            fadeOut.style.display = "block";
            fadeInBtn.style.display = "none";
            fadeIn.style.display = "none";

            // Trigger the pop-in by changing its opacity
            fadeOutBtn.style.opacity = 1;
            fadeOut.style.opacity = 1;
        }, 500);
    });
</script>