import { Link } from 'react-router-dom'
import '../styles/Home.css'

export default function Home() {
  return (
    <div className="page">
      <section className="hero">
        <div>
          <h1>Handcrafted pieces, made just for you.</h1>
          <p>
            Every item is designed with care and personalized to your style.
            Explore our curated collection and craft your perfect gift.
          </p>
          <Link className="btn" to="/shop">
            Visit the Shop
          </Link>
        </div>

        <div className="hero-card">
          <h3>Why customers love us</h3>
          <p>• Small‑batch, artisan quality</p>
          <p>• Custom text & color options</p>
          <p>• Gift‑ready packaging</p>
        </div>
      </section>
    </div>
  )
}

