import { ComponentFixture, TestBed } from '@angular/core/testing';

import { VideoNewwComponent } from './video-neww.component';

describe('VideoNewwComponent', () => {
  let component: VideoNewwComponent;
  let fixture: ComponentFixture<VideoNewwComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ VideoNewwComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(VideoNewwComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
