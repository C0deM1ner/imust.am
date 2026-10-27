<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Tag;
use Database\Seeders\Concerns\CopiesSeedImages;
use Illuminate\Database\Seeder;

/**
 * Seeds the portfolio services (tags) and sample projects in hy, ru and en, in display order.
 * Existing rows (matched by slug) are left alone, so edits made in Nova are never overwritten.
 */
class PortfolioSeeder extends Seeder
{
    use CopiesSeedImages;

    public function run(): void
    {
        foreach ($this->tags() as $slug => $name) {
            Tag::withoutGlobalScopes()->firstOrCreate(['slug' => $slug], ['name' => $name]);
        }

        $tagIds = Tag::withoutGlobalScopes()->pluck('id', 'slug');

        foreach ($this->projects() as $slug => $data) {
            if (Project::withoutGlobalScopes()->where('slug', $slug)->exists()) {
                $this->command?->warn("  {$slug} already exists, skipped.");

                continue;
            }

            $tags = $data['tags'];
            unset($data['tags']);

            $project = Project::create(['slug' => $slug] + $data);
            $project->tags()->sync($tagIds->only($tags)->values());
        }
    }

    protected function tags(): array
    {
        return [
            'website' => ['hy' => 'Կայքեր', 'ru' => 'Сайты', 'en' => 'Websites'],
            'social' => ['hy' => 'Սոցցանցեր', 'ru' => 'Соцсети', 'en' => 'Social media'],
            'video' => ['hy' => 'Վիդեո', 'ru' => 'Видео', 'en' => 'Video'],
            'ads' => ['hy' => 'Գովազդ', 'ru' => 'Реклама', 'en' => 'Ads'],
            'branding' => ['hy' => 'Բրենդինգ', 'ru' => 'Брендинг', 'en' => 'Branding'],
        ];
    }

    // TODO: sample projects. Replace them with real case studies in Nova.
    protected function projects(): array
    {
        return [
            'bakery-launch' => [
                'title' => ['hy' => 'Լոգոյից մինչև առաջին հաճախորդները', 'ru' => 'От логотипа до первых клиентов', 'en' => 'From logo to first customers'],
                'client' => ['hy' => 'Ընտանեկան հացատուն', 'ru' => 'Семейная пекарня', 'en' => 'Family bakery'],
                'year' => 2026,
                'tags' => ['website', 'social', 'branding'],
                'cover' => $this->image('portfolio/bakery-launch.webp', 'projects'),
                'summary' => ['hy' => 'Բրենդ, կայք և սոցցանցերի կարգավորում Facebook-ում, Instagram-ում և Google Business Profile-ում։', 'ru' => 'Бренд, сайт и настройка соцсетей: Facebook, Instagram и Google Business Profile.', 'en' => 'Brand, website and social media setup on Facebook, Instagram and Google Business Profile.'],
                'challenge' => ['hy' => 'Նոր ընտանեկան հացատանը պետք էր հիշվող անուն և միջոց, որ թաղամասն այն գտնի հենց առաջին օրվանից։', 'ru' => 'Новой семейной пекарне нужно было запоминающееся имя и способ, чтобы район узнал о ней с первого дня.', 'en' => 'A new family bakery needed a name people would remember and a way for the neighborhood to find it from day one.'],
                'work' => ['hy' => "Լոգո, գույներ և փաթեթավորման պիտակներ\nՄեկ էջանոց եռալեզու կայք՝ մենյուով և աշխատանքային ժամերով\nFacebook, Instagram և Google Business Profile՝ կարգավորված մինչև բացումը", 'ru' => "Логотип, цвета и наклейки для упаковки\nОдностраничный сайт на трёх языках с меню и часами работы\nFacebook, Instagram и Google Business Profile, настроенные до открытия", 'en' => "Logo, colors and packaging stickers\nA one-page website in three languages with the menu and opening hours\nFacebook, Instagram and Google Business Profile set up before the opening"],
                'result' => ['hy' => 'Հացատունը բացվեց ամբողջական օնլայն ներկայությամբ, և առաջին հաճախորդներն այն գտան Google Maps-ում և Instagram-ում։', 'ru' => 'Пекарня открылась с полным присутствием в сети, и первые клиенты нашли её в Google Maps и Instagram.', 'en' => 'The bakery opened with a complete online presence, so the first customers found it on Google Maps and Instagram.'],
            ],
            'dental-social' => [
                'title' => ['hy' => 'Սոցցանցեր, որոնք լրացնում են գրաֆիկը', 'ru' => 'Соцсети, которые заполняют расписание', 'en' => 'Social media that fills the calendar'],
                'client' => ['hy' => 'Ատամնաբուժական կլինիկա', 'ru' => 'Стоматологическая клиника', 'en' => 'Dental clinic'],
                'year' => 2026,
                'tags' => ['social', 'ads'],
                'cover' => $this->image('portfolio/dental-social.webp', 'projects'),
                'summary' => ['hy' => 'Ամսական բովանդակության պլան, «առաջ և հետո» գրառումներ և թիրախավորված գովազդ Facebook-ում ու Instagram-ում։', 'ru' => 'Ежемесячный контент-план, посты «до и после» и таргетированная реклама в Facebook и Instagram.', 'en' => 'A monthly content plan, before and after posts and targeted Facebook and Instagram ads.'],
                'challenge' => ['hy' => 'Կլինիկան հազվադեպ էր հրապարակումներ անում, և էջերը ոչ աշխատանքի որակն էին ցույց տալիս, ոչ էլ նոր պացիենտներ բերում։', 'ru' => 'Клиника публиковала посты редко, а её страницы не показывали качество работы и не приводили новых пациентов.', 'en' => 'The clinic posted rarely, and its pages neither showed the quality of the work nor brought new patients.'],
                'work' => ['hy' => "Ամսական բովանդակության պլան՝ նախապես համաձայնեցված\n«Առաջ և հետո» գրառումներ և կարճ տեսանյութեր բժիշկների հետ\nԹիրախավորված գովազդ Facebook-ում և Instagram-ում մոտակա բնակիչների համար", 'ru' => "Ежемесячный контент-план, согласованный заранее\nПосты «до и после» и короткие видео с врачами\nТаргетированная реклама в Facebook и Instagram для жителей района", 'en' => "A monthly content plan agreed in advance\nBefore and after posts and short videos with the doctors\nTargeted Facebook and Instagram ads for people living nearby"],
                'result' => ['hy' => 'Էջերն այժմ կանոնավոր թարմացվում են, և գովազդն ամեն ամիս ընդունելության հայտեր է բերում հաղորդագրություններով։', 'ru' => 'Страницы теперь обновляются регулярно, а реклама каждый месяц приносит заявки на приём в сообщениях.', 'en' => 'The pages now post regularly, and the ads bring appointment requests through messages every month.'],
            ],
            'hotel-video' => [
                'title' => ['hy' => 'Սենյակների տուրեր և ռիլսեր ամեն սեզոնի համար', 'ru' => 'Обзоры номеров и рилсы на каждый сезон', 'en' => 'Room tours and reels for every season'],
                'client' => ['hy' => 'Բուտիկ հյուրանոց, Դիլիջան', 'ru' => 'Бутик-отель, Дилижан', 'en' => 'Boutique hotel, Dilijan'],
                'year' => 2026,
                'tags' => ['video', 'social'],
                'cover' => $this->image('portfolio/hotel-video.webp', 'projects'),
                'summary' => ['hy' => 'Կարճ տեսանյութերի նկարահանում և մոնտաժ Instagram-ի և YouTube-ի համար։', 'ru' => 'Съёмка и монтаж коротких видео для Instagram и YouTube.', 'en' => 'Shooting and editing short videos for Instagram and YouTube.'],
                'challenge' => ['hy' => 'Հյուրերն ամրագրում էին լուսանկարներով, որոնք ցույց չէին տալիս ո՛չ սենյակները, ո՛չ էլ հյուրանոցի շրջակայքը։', 'ru' => 'Гости бронировали по фотографиям, на которых не было видно ни номеров, ни видов вокруг отеля.', 'en' => 'Guests booked from photos that showed neither the rooms nor the views around the hotel.'],
                'work' => ['hy' => "Սենյակների տուրեր՝ նկարահանված բոլոր սեզոններին\nԿարճ ռիլսեր հյուրանոցի, խոհանոցի և շրջակայքի մասին\nՄոնտաժ և ենթագրեր Instagram-ի և YouTube-ի համար", 'ru' => "Обзоры номеров, снятые в каждый сезон\nКороткие рилсы об отеле, кухне и окрестностях\nМонтаж и субтитры для Instagram и YouTube", 'en' => "Room tours filmed in every season\nShort reels about the hotel, the food and the area\nEditing and captions for Instagram and YouTube"],
                'result' => ['hy' => 'Հյուրանոցն ունի տեսանյութերի պաշար, որը հրապարակում է ամբողջ տարին և օգտագործում ամրագրման էջերում։', 'ru' => 'У отеля есть библиотека видео, которую он публикует весь год и использует на страницах бронирования.', 'en' => 'The hotel has a library of videos it posts all year and uses on its booking pages.'],
            ],
            'cafe-website' => [
                'title' => ['hy' => 'Եռալեզու կայք՝ օնլայն մենյուով', 'ru' => 'Трёхъязычный сайт с онлайн-меню', 'en' => 'A trilingual website with an online menu'],
                'client' => ['hy' => 'Սրճարան, Երևան', 'ru' => 'Кофейня, Ереван', 'en' => 'Coffee shop, Yerevan'],
                'year' => 2025,
                'tags' => ['website'],
                'cover' => $this->image('portfolio/cafe-website.webp', 'projects'),
                'summary' => ['hy' => 'Դիզայն, բովանդակություն երեք լեզվով և հիմնական SEO, որպեսզի զբոսաշրջիկներն ու տեղացիները գտնեն նույն մենյուն։', 'ru' => 'Дизайн, тексты на трёх языках и базовое SEO, чтобы туристы и местные находили одно и то же меню.', 'en' => 'Design, content in three languages and basic SEO, so tourists and locals find the same menu.'],
                'challenge' => ['hy' => 'Զբոսաշրջիկները չէին կարողանում կարդալ մենյուն, իսկ սրճարանը կայք չուներ, որպեսզի երևար որոնման մեջ։', 'ru' => 'Туристы не могли прочитать меню, а у кофейни не было сайта, чтобы появляться в поиске.', 'en' => 'Tourists could not read the menu, and the coffee shop had no website to show up in search.'],
                'work' => ['hy' => "Կայքի դիզայն և օնլայն մենյու\nԲովանդակություն հայերեն, ռուսերեն և անգլերեն\nՀիմնական SEO և կապ Google Business Profile-ի հետ", 'ru' => "Дизайн сайта и онлайн-меню\nТексты на армянском, русском и английском\nБазовое SEO и связь с Google Business Profile", 'en' => "Website design and an online menu\nContent in Armenian, Russian and English\nBasic SEO and a link with the Google Business Profile"],
                'result' => ['hy' => 'Այցելուները գտնում են նույն մենյուն իրենց լեզվով, և սրճարանն այժմ երևում է տեղային որոնման մեջ։', 'ru' => 'Гости находят одно и то же меню на своём языке, а кофейня теперь видна в локальном поиске.', 'en' => 'Visitors find the same menu in their own language, and the coffee shop now shows up in local search.'],
            ],
            'auto-ads' => [
                'title' => ['hy' => 'Google Ads շտապ վերանորոգման համար', 'ru' => 'Google Ads для срочного ремонта', 'en' => 'Google Ads for urgent repairs'],
                'client' => ['hy' => 'Ավտոսպասարկման կենտրոն', 'ru' => 'Автосервис', 'en' => 'Car service center'],
                'year' => 2025,
                'tags' => ['ads'],
                'cover' => $this->image('portfolio/auto-ads.webp', 'projects'),
                'summary' => ['hy' => 'Որոնողական արշավներ և Google Business Profile, որոնք զանգեր են բերում նույն օրը։', 'ru' => 'Поисковые кампании и Google Business Profile, которые приносят звонки в тот же день.', 'en' => 'Search campaigns and a Google Business Profile that bring calls the same day.'],
                'challenge' => ['hy' => 'Սպասարկման կենտրոնին պետք էին զանգեր շտապ վերանորոգման կարիք ունեցող վարորդներից, ոչ թե պարզապես այցելություններ էջին։', 'ru' => 'Автосервису нужны были звонки от водителей со срочным ремонтом, а не просто посещения страницы.', 'en' => 'The service center needed calls from drivers with urgent repairs, not just visits to its page.'],
                'work' => ['hy' => "Google Ads որոնողական արշավներ շտապ վերանորոգման հարցումների համար\nԱմբողջական Google Business Profile՝ լուսանկարներով և աշխատանքային ժամերով\nԶանգերի հետևում և ամսական Google Analytics հաշվետվություն", 'ru' => "Поисковые кампании Google Ads по запросам о срочном ремонте\nПолный Google Business Profile с фотографиями и часами работы\nОтслеживание звонков и ежемесячный отчёт Google Analytics", 'en' => "Google Ads search campaigns for urgent repair searches\nA complete Google Business Profile with photos and opening hours\nCall tracking and a monthly Google Analytics report"],
                'result' => ['hy' => 'Գովազդը ցուցադրվում է միայն սպասարկման տարածքում, իսկ ամսական հաշվետվությունները ցույց են տալիս, թե որ որոնումներն են զանգեր բերում։', 'ru' => 'Реклама показывается только в зоне обслуживания, а ежемесячные отчёты показывают, какие запросы приносят звонки.', 'en' => 'The ads run only in the service area, and the monthly reports show which searches bring calls.'],
            ],
            'fashion-brand' => [
                'title' => ['hy' => 'Վիզուալ ինքնություն տեղական բրենդի համար', 'ru' => 'Айдентика для местной марки', 'en' => 'A visual identity for a local label'],
                'client' => ['hy' => 'Հագուստի բրենդ', 'ru' => 'Бренд одежды', 'en' => 'Clothing brand'],
                'year' => 2025,
                'tags' => ['branding', 'social'],
                'cover' => $this->image('portfolio/fashion-brand.webp', 'projects'),
                'summary' => ['hy' => 'Լոգո, գույներ և վիզուալ ոճ կայքի, սոցցանցերի և փաթեթավորման համար։', 'ru' => 'Логотип, цвета и визуальный стиль для сайта, соцсетей и упаковки.', 'en' => 'Logo, colors and a visual style for the website, social media and packaging.'],
                'challenge' => ['hy' => 'Բրենդը լավ էր վաճառվում տոնավաճառներում, բայց ամեն էջում, գրառման և փաթեթի վրա տարբեր տեսք ուներ։', 'ru' => 'Марка хорошо продавалась на маркетах, но на каждой странице, в каждом посте и на каждой упаковке выглядела по-разному.', 'en' => 'The label sold well at markets but looked different on every page, post and package.'],
                'work' => ['hy' => "Լոգո և գույների ու տառատեսակների պարզ համակարգ\nՁևանմուշներ սոցցանցերի գրառումների և սթորիների համար\nՓաթեթավորման և պիտակների դիզայն", 'ru' => "Логотип и простая система цветов и шрифтов\nШаблоны для постов и сторис в соцсетях\nДизайн упаковки и бирок", 'en' => "A logo and a simple set of colors and fonts\nTemplates for social media posts and stories\nPackaging and tag design"],
                'result' => ['hy' => 'Բրենդն այժմ նույն տեսքն ունի ամենուր, որտեղ հաճախորդները հանդիպում են նրան՝ օնլայն և խանութում։', 'ru' => 'Теперь бренд выглядит одинаково везде, где его встречают клиенты: в сети и в магазине.', 'en' => 'The brand now looks the same everywhere customers meet it, online and in the shop.'],
            ],
            'clinic-website' => [
                'title' => ['hy' => 'Կայք՝ բժիշկների էջերով', 'ru' => 'Сайт с профилями врачей', 'en' => 'A website with doctor profiles'],
                'client' => ['hy' => 'Բժշկական կենտրոն', 'ru' => 'Медицинский центр', 'en' => 'Medical center'],
                'year' => 2025,
                'tags' => ['website'],
                'cover' => $this->image('portfolio/clinic-website.webp', 'projects'),
                'summary' => ['hy' => 'Հստակ կառուցվածք, բժիշկների էջեր և ընդունելության հայտեր երեք լեզվով։', 'ru' => 'Понятная структура, страницы врачей и заявки на приём на трёх языках.', 'en' => 'A clear structure, doctor pages and appointment requests in three languages.'],
                'challenge' => ['hy' => 'Պացիենտները զանգում էին հարցնելու, թե որ բժշկին դիմեն, քանի որ հին կայքը չէր բացատրում ծառայությունները։', 'ru' => 'Пациенты звонили, чтобы спросить, к какому врачу идти, потому что старый сайт не объяснял услуги.', 'en' => 'Patients called to ask which doctor to see, because the old website did not explain the services.'],
                'work' => ['hy' => "Հստակ կառուցվածք՝ ըստ բաժինների և ծառայությունների\nԷջ յուրաքանչյուր բժշկի համար՝ լուսանկարով և փորձի նկարագրությամբ\nԸնդունելության հայտի ձևեր երեք լեզվով", 'ru' => "Понятная структура по отделениям и услугам\nСтраница каждого врача с фото и опытом работы\nФормы записи на приём на трёх языках", 'en' => "A clear structure by department and service\nA page for every doctor with a photo and their experience\nAppointment request forms in three languages"],
                'result' => ['hy' => 'Պացիենտները բժշկին ընտրում են կայքում և հայտ են ուղարկում՝ առանց նախապես զանգելու։', 'ru' => 'Пациенты выбирают врача на сайте и отправляют заявку, не звоня заранее.', 'en' => 'Patients choose a doctor on the website and send a request without calling first.'],
            ],
            'restaurant-reels' => [
                'title' => ['hy' => 'Ռիլսեր՝ նկարահանված մեր ստուդիայում', 'ru' => 'Рилсы, снятые в нашей студии', 'en' => 'Reels shot in our studio'],
                'client' => ['hy' => 'Ռեստորան', 'ru' => 'Ресторан', 'en' => 'Restaurant'],
                'year' => 2024,
                'tags' => ['video'],
                'cover' => $this->image('portfolio/restaurant-reels.webp', 'projects'),
                'summary' => ['hy' => 'Սննդի մասին բովանդակություն՝ նկարահանված I MUST ստուդիայում, մեր լուսավորությամբ և մոնտաժով։', 'ru' => 'Фуд-контент, снятый в студии I MUST, с нашим светом и монтажом.', 'en' => 'Food content filmed in the I MUST studio, with our own lighting and editing.'],
                'challenge' => ['hy' => 'Ռեստորանը ցանկանում էր պրոֆեսիոնալ տեսքով սննդի տեսանյութեր՝ առանց նկարահանման համար խոհանոցը փակելու։', 'ru' => 'Ресторан хотел профессиональные видео с едой, не закрывая кухню ради съёмки.', 'en' => 'The restaurant wanted professional food videos without closing the kitchen for a shoot.'],
                'work' => ['hy' => "Նկարահանում I MUST ստուդիայում՝ պատրաստի ֆոտոզոնաներով\nՍննդի նկարահանման համար մեր լուսավորությունը\nՄեկ ամսվա ռիլսեր՝ մոնտաժված մեկ նկարահանման օրվա նյութից", 'ru' => "Съёмка в студии I MUST с готовыми фотозонами\nНаш собственный свет для съёмки еды\nРилсы на месяц, смонтированные из материала одного съёмочного дня", 'en' => "Shooting in the I MUST studio with ready photo zones\nOur own lighting setup for food\nA month of reels edited from one shooting day"],
                'result' => ['hy' => 'Ռեստորանը ստուդիայում անցկացրած մեկ օրից ստանում է մեկ ամսվա պատրաստի ռիլսեր։', 'ru' => 'Ресторан получает готовые рилсы на месяц за один день в студии.', 'en' => 'The restaurant gets a month of ready reels from a single day in the studio.'],
            ],
            'tour-campaign' => [
                'title' => ['hy' => 'Արշավ սեզոնի մեկնարկի համար', 'ru' => 'Кампания к старту сезона', 'en' => 'A campaign for the start of the season'],
                'client' => ['hy' => 'Տուրիստական գործակալություն', 'ru' => 'Туристическое агентство', 'en' => 'Travel agency'],
                'year' => 2024,
                'tags' => ['ads', 'video'],
                'cover' => $this->image('portfolio/tour-campaign.webp', 'projects'),
                'summary' => ['hy' => 'Վիդեոգովազդ և Google Ads ամառային տուրերի համար՝ ամսական Google Analytics հաշվետվություններով։', 'ru' => 'Видеореклама и Google Ads для летних туров с ежемесячными отчётами Google Analytics.', 'en' => 'Video ads and Google Ads for summer tours, with monthly Google Analytics reports.'],
                'challenge' => ['hy' => 'Գործակալությանը պետք էր վաճառել ամառային տուրերը սեզոնի սկզբի ամրագրումների կարճ ժամանակահատվածում։', 'ru' => 'Агентству нужно было продать летние туры за короткое окно бронирования в начале сезона.', 'en' => 'The agency had to sell summer tours in the short booking window at the start of the season.'],
                'work' => ['hy' => "Կարճ վիդեոգովազդներ նախորդ տուրերի կադրերից\nGoogle Ads արշավներ յուրաքանչյուր ուղղության համար\nԱմսական Google Analytics հաշվետվություններ սեզոնի ընթացքում", 'ru' => "Короткие видеоролики из кадров прошлых туров\nКампании Google Ads для каждого направления\nЕжемесячные отчёты Google Analytics в течение сезона", 'en' => "Short video ads made from footage of earlier tours\nGoogle Ads campaigns for each destination\nMonthly Google Analytics reports during the season"],
                'result' => ['hy' => 'Արշավը գործեց ամրագրումների ողջ ժամանակահատվածում, իսկ հաշվետվությունները ցույց տվեցին, թե որ տուրերն արժե ավելի ակտիվ գովազդել։', 'ru' => 'Кампания работала всё окно бронирования, а отчёты показали, какие туры стоит продвигать активнее.', 'en' => 'The campaign ran through the whole booking window, and the reports showed which tours to promote more.'],
            ],
        ];
    }
}
