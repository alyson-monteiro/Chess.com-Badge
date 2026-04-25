interface StatsCardProps {
  avatarUrl?: string;
  username?: string;
  rating: number;
  mode: 'Rapid' | 'Blitz' | 'Bullet';
  theme: 'blue' | 'purple' | 'green';
}

function StatsCard({ avatarUrl, username, rating, mode, theme }: StatsCardProps) {
  const gradients = {
    blue: 'bg-gradient-to-br from-[#58cc02] to-[#1cb0f6]',
    purple: 'bg-gradient-to-br from-[#ce82ff] to-[#7e3af2]',
    green: 'bg-gradient-to-br from-[#58cc02] to-[#14a800]',
  };

  return (
    <div
      className={`relative w-[280px] h-[280px] rounded-[28px] ${gradients[theme]} flex flex-col items-center justify-center gap-3 p-6`}
      style={{ boxShadow: '0 4px 12px rgba(0, 0, 0, 0.08)' }}
    >
      {/* Chess Piece Logo - Top Left */}
      <svg
        xmlns="http://www.w3.org/2000/svg"
        viewBox="0 0 48 48"
        className="absolute top-3 left-3 w-5 h-5 opacity-90"
      >
        <path fill="#689f38" d="M28.001,19h-8.002c0,16.944-10,9.713-10,23c0,0,0.546,2,14.001,2c13.455,0,14.001-2,14.001-2 C38.001,28.713,28.001,35.944,28.001,19z"></path>
        <path fill="#33691e" d="M28.001,19h-8.002c0,1.127-0.047,2.141-0.13,3.067c1.869,0.18,5.76,0.63,5.76,3.765 C25.629,28.534,23.891,37.51,19,38c-4.461,0.447-8.273-1.094-8.273-1.094C10.272,38.18,9.999,39.81,9.999,42c0,0,0.546,2,14.001,2 c13.455,0,14.001-2,14.001-2C38.001,28.713,28.001,35.944,28.001,19z"></path>
        <path fill="#689f38" d="M26.02,14H24h-2.02c-1.986,1.334-3.972,2.668-5.957,4.001c0.03,0.428,0.113,0.997,0.332,1.634 c0.197,0.573,0.446,1.032,0.663,1.371l6.984-0.01l6.981,0.01c0.217-0.339,0.466-0.798,0.663-1.371 c0.219-0.637,0.302-1.206,0.332-1.634C29.992,16.668,28.006,15.334,26.02,14z"></path>
        <path fill="#33691e" d="M26,20.999l1.084,0.483l0.976-0.48l2.922,0.004c0.217-0.339,0.466-0.798,0.663-1.371 c0.219-0.637,0.302-1.206,0.332-1.634c-1.986-1.334-3.972-2.668-5.957-4.001H24l3,4L26,20.999z"></path>
        <circle cx="24" cy="10" r="7" fill="#689f38"></circle>
        <path fill="#33691e" d="M27.884,4.178c0.743,1.112,1.178,2.447,1.178,3.884c0,3.016-1.907,5.586-4.581,6.571l1.544,2.07 c0.435-0.131,1.04,0.059,1.434-0.15c0.361-0.191,0.515-0.775,0.835-1.024C29.94,14.249,31,12.248,31,10 C31,7.571,29.762,5.433,27.884,4.178z"></path>
        <path fill="#9ccc65" d="M24.683,4.727c0.372,0.973-0.526,2.556-2.006,3.536c-1.48,0.979-2.982,0.984-3.354,0.011 s0.526-2.556,2.006-3.536S24.31,3.753,24.683,4.727z"></path>
      </svg>

      {/* Avatar - Square with rounded corners */}
      <div
        className="w-20 h-20 rounded-[14px] bg-white/20 flex items-center justify-center overflow-hidden"
        style={{ boxShadow: '0 2px 8px rgba(0, 0, 0, 0.1)' }}
      >
        {avatarUrl ? (
          <img src={avatarUrl} alt="Avatar" className="w-full h-full object-cover" />
        ) : (
          <div className="w-full h-full bg-white/40 flex items-center justify-center">
            <svg className="w-10 h-10 text-white/60" fill="currentColor" viewBox="0 0 24 24">
              <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
            </svg>
          </div>
        )}
      </div>

      {/* Username */}
      {username && (
        <p className="text-white/80 text-sm font-medium tracking-wide">
          {username}
        </p>
      )}

      {/* Main Rating */}
      <p className="text-white text-6xl font-bold tracking-tight">
        {rating}
      </p>

      {/* Game Mode Label */}
      <p className="text-white/70 text-xs font-medium uppercase tracking-wider">
        {mode}
      </p>
    </div>
  );
}

export default function App() {
  return (
    <div className="size-full flex items-center justify-center gap-8 p-12 bg-gray-50">
      <StatsCard
        username="alexdev"
        rating={1820}
        mode="Rapid"
        theme="blue"
      />
      <StatsCard
        username="codewiz"
        rating={2145}
        mode="Blitz"
        theme="purple"
      />
      <StatsCard
        rating={1654}
        mode="Bullet"
        theme="green"
      />
    </div>
  );
}