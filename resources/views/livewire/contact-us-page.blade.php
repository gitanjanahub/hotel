<div>
    <!-- Contact Section Begin -->
    <section class="contact-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <div class="contact-text">
                        <h2>Contact Info</h2>
                        <p>{{ $company_details->description }}</p>
                        <table>
                            <tbody>
                                <tr>
                                    <td class="c-o">Address:</td>
                                    <td>{{ $company_details->address }}</td>
                                </tr>
                                <tr>
                                    <td class="c-o">Phone:</td>
                                    <td>{{ $company_details->phone }}</td>
                                </tr>
                                <tr>
                                    <td class="c-o">Email:</td>
                                    <td>{{ $company_details->email }}</td>
                                </tr>
                                <tr>
                                    <td class="c-o">Fax:</td>
                                    <td>{{ $company_details->fax }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-lg-7 offset-lg-1">

                    @if (session()->has('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <form wire:submit.prevent="submit" class="contact-form">
                        <div class="row">
                            <div class="col-lg-6">
                                <input type="text" wire:model="name" placeholder="Your Name">
                                @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-lg-6">
                                <input type="email" wire:model="email" placeholder="Your Email">
                                @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-lg-12">
                                <textarea wire:model="message" placeholder="Your Message"></textarea>
                                @error('message') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-lg-12">
                                <button type="submit">Submit Now</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Dynamic Google Map -->
            <div class="map">
                @if ($company_details->latitude && $company_details->longitude)
                    <iframe
                        src="https://www.google.com/maps/embed/v1/place?key=YOUR_GOOGLE_MAPS_API_KEY&q={{ $company_details->latitude }},{{ $company_details->longitude }}"
                        width="100%" height="470" style="border:0;" allowfullscreen="">
                    </iframe>
                @else
                    <p class="text-center text-danger">Map location is not available.</p>
                @endif
            </div>
        </div>
    </section>
    <!-- Contact Section End -->
</div>
