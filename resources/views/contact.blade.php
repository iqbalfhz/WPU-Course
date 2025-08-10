<x-layout :title="$title">
    <main>
        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6">
                    <h2 class="text-lg font-medium leading-6 text-gray-900">{{ $title }}</h2>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500">
                        {{ $description ?? 'This is the about page where you can learn more about our website and its purpose.' }}
                    </p>
                </div>
                <div class="border-t border-gray-200">
                    <dl>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">About Us</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                                We are dedicated to providing the best content and services to our users. Our team works
                                tirelessly to ensure that
                                you have the best experience possible on our website.
                            </dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Our Mission</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                                Our mission is to empower individuals with knowledge and resources that can help them
                                achieve their goals. We believe in the power
                                of information and strive to make it accessible to everyone.
                            </dd>
                        </div>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Contact Us</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                                If you have any questions or feedback, feel free to reach out to us through our contact
                                page. We value your input and are always looking to improve our services.
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </main>
</x-layout>
